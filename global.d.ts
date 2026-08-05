declare module '*.css' {
  const content: string

  export default content
}

declare module 'stylelint-config-recommended' {
  import type { Config } from 'stylelint'

  const config: Config

  export default config
}

declare module '@wordpress/scripts/config/webpack.config.js' {
  import type { Configuration } from 'webpack'

  const config: Configuration

  export default config
}

declare module '@wordpress/scripts/utils/config' {
  import type { EntryObject } from 'webpack'

  const getWebpackEntryPoints: () => EntryObject
}

interface WP {
  blockEditor: typeof import('@wordpress/block-editor')
  components: typeof import('@wordpress/components')
  compose: typeof import('@wordpress/compose')
  data: typeof import('@wordpress/data')
  hooks: typeof import('@wordpress/hooks')
  media: (options: {
    button: { text: string }
    library: { type?: string[] }
    multiple: boolean
    title: string
  }) => {
    [x: string]: unknown
    on: (event: string, callback: () => unknown) => void
    open: () => void
    state: () => {
      get: (event: string) => {
        toJSON: () => {
          alt?: string
          caption?: string
          description?: string
          filename: string
          filesizeHumanReadable: string
          filesizeInBytes: number
          icon: string
          id: number
          lottieJSON: import('@aarsteinmedia/lottie-web').AnimationData
          mime: string
          name: string
          subtype: string
          title: string
          type: string
          url: string
        }
      }[]
    }
  }
}

declare const wp: WP