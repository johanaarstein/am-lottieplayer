import type { BlockEditProps } from '@wordpress/blocks'

import { useState } from '@wordpress/element'

import type { PlayerComponentProps } from '@/types'

import PlayerComponent from '@/components/Placeholder/PlayerComponent'
import UploadComponent from '@/components/Placeholder/UploadComponent'
import useComponentDidUpdate from '@/hooks/useComponentDidUpdate'

export default function Placeholder( {
  attributes,
  clientId,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const [ state, setState ] = useState( { isPlaceholder: true } )

  useComponentDidUpdate(() => {
    setState(() => ({ isPlaceholder: !attributes.src || attributes.src === '' }))
    // console.log('👸', attributes.src)
  }, [attributes.src])

  return (
    <>
      { state.isPlaceholder ?
        <UploadComponent
          attributes={ attributes }
          setAttributes={ setAttributes }
        />
        :
        <PlayerComponent
          attributes={ attributes }
          clientId={ clientId }
        />
      }
    </>
  )
}
