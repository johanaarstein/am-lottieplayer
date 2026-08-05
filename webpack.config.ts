import type { Configuration } from 'webpack'

import defaults from '@wordpress/scripts/config/webpack.config.js'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'

const __dirname = dirname(fileURLToPath(import.meta.url)),
  config: Configuration = {
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
    },
    resolve: {
      ...defaults.resolve,
      alias: { '@': resolve(__dirname, 'src') },
      extensions: [
        ...defaults.resolve?.extensions ?? [],
        '.ts',
        '.tsx'
      ],
    },
  }

export default config
