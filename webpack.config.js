// import type { Configuration } from 'webpack'

const defaults = require('@wordpress/scripts/config/webpack.config'),
 { resolve } = require('node:path')

const config = {
  ...defaults,
  entry: {
    admin: resolve(
      __dirname, 'src', 'admin.tsx'
    ),
    'lottiecover/index': resolve(
      __dirname, 'src', 'lottiecover', 'index.ts'
    ),
    'lottieplayer/index': resolve(
      __dirname, 'src', 'lottieplayer', 'index.ts'
    ),
    media: resolve(
      __dirname, 'src', 'media.ts'
    ),
  },
  resolve: {
    ...defaults.resolve,
    alias: {
      ...defaults.resolve?.alias ?? [],
      '@': resolve(__dirname, 'src'),
    },
    extensions: [
      ...defaults.resolve?.extensions ?? [],
      '.ts',
      '.tsx'
    ],
  },
}

// export default config
module.exports = config
