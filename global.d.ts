declare module 'stylelint-config-recommended' {
  import type { Config } from 'stylelint'

  const config: Config

  export default config
}

declare module '@wordpress/scripts/config/webpack.config' {
  import type { Configuration } from 'webpack'

  const config: Configuration

  export default config
}

declare module '@wordpress/scripts/utils/config' {
  import type { EntryObject } from 'webpack'

  const getWebpackEntryPoints: () => EntryObject
}

interface MediaOptions {
  button: { text: string }
  library: { type?: string[] }
  multiple: boolean
  title: string
}

interface WP {
  blockEditor: typeof import('@wordpress/block-editor')
  components: typeof import('@wordpress/components')
  compose: typeof import('@wordpress/compose')
  data: typeof import('@wordpress/data')
  hooks: typeof import('@wordpress/hooks')
  media: (options: MediaOptions) => Media
}

declare const wp: WP