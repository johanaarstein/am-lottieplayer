/* eslint-disable func-style */
/* eslint-disable prefer-rest-params */


import { trailingslashit } from './utils'

function overrideXHR() {
  const { open } = XMLHttpRequest.prototype,
    { send } = XMLHttpRequest.prototype

  function openReplacement(
    this: XMLHttpRequest,
    method: string,
    url: string | URL,
    async?: boolean,
    _user?: string,
    _password?: string
  ) {
    const syncMode = async === false ? 'sync' : 'async'

    console.info(`Preparing ${ syncMode } HTTP request : ${ method } ${ url }`)

    open.apply(this,
      arguments as unknown as [
				method: string,
				url: string | URL,
				async: boolean,
      ])
  }

  function sendReplacement(this: XMLHttpRequest & {
    _onreadystatechange?: (
      this: XMLHttpRequest,
      ev: Event
    ) => unknown;
  },
  data?: Document | XMLHttpRequestBodyInit | null) {
    if ( ! ( data instanceof FormData ) || ! aamdPHPVariables ) {
      send.apply(this,
        arguments as unknown as [
					body?: Document | XMLHttpRequestBodyInit | null | undefined,
        ])

      return
    }

    const name = data.get( 'name' )

    if (
      typeof name !== 'string' ||
      ! name.toLowerCase().endsWith( '.lottie' ) &&
      ! name.toLowerCase().endsWith( '.json' )
    ) {
      send.apply(this,
        arguments as unknown as [
					body?: Document | XMLHttpRequestBodyInit | null | undefined,
        ])

      return
    }

    const file = data.get( 'async-upload' )

    if ( ! ( file instanceof File ) ) {
      send.apply(this,
        arguments as unknown as [
					body?: Document | XMLHttpRequestBodyInit | null | undefined,
        ])

      return
    }

    const fileReader = new FileReader()

    fileReader.onloadend = async ( { target } ) => {
      try {
        if ( ! ( target?.result instanceof ArrayBuffer ) ) {
          return
        }
        const lottieBlob = new Blob( [ target.result ] ),
          objectURL = URL.createObjectURL( lottieBlob )

        const dlp = dotLottiePlayer()

        dlp.hidden = true

        document.body.appendChild( dlp )

        await dlp.load( objectURL )
        const svg = dlp.snapshot( false )

        URL.revokeObjectURL( objectURL )

        if ( ! svg ) {
          throw new Error( 'Failed to create thumbnail' )
        }

        const svgFile = new File(
            [ svg ],
            name.replace( /\.[^/.]+$/, '.svg' ),
            { type: 'image/svg+xml' }
          ),
          formData = new FormData()

        formData.append('aamd_thumbnail_submit',
          aamdPHPVariables.nonce)
        formData.append( 'thumbnail', svgFile )
        const response = await fetch(`${ trailingslashit(aamdPHPVariables.pluginUrl) }includes/upload-thumbnail.php`,
          {
            body: formData,
            method: 'POST'
          })

        if ( ! response.ok ) {
          throw new Error( response.statusText )
        }

        // const responseData: unknown = await response.json();
      } catch ( error ) {
        console.error( error )
      }
    }

    fileReader.readAsArrayBuffer( file )

    send.apply(this,
      arguments as unknown as [
				body?: Document | XMLHttpRequestBodyInit | null | undefined,
      ])
  }

  XMLHttpRequest.prototype.open = openReplacement
  XMLHttpRequest.prototype.send = sendReplacement
}

overrideXHR()
