import fs from 'node:fs'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'

import type pkg from './package.json'

const __dirname = dirname(fileURLToPath(import.meta.url)),
  { version }: typeof pkg = JSON.parse(fs.readFileSync(resolve(__dirname, 'package.json'), 'utf8'))

if (!/^\d+\.\d+\.\d+$/.test(version)) {
  console.error(`Invalid version in package.json: ${version}`)
  process.exit(1)
}

const targets = [
  {
    file: 'am-lottieplayer.php',
    patterns: [
      // Plugin header
      /^( \* Version: +)\S+/m,
      // Version constant
      /(define\(\s*'AAMD_LOTTIE_VERSION',\s*')[^']+(')/,
    ],
  },
  {
    file: 'readme.txt',
    patterns: [/^(Stable Tag:\s*)\S+/im],
  },
]

targets.forEach(({ file, patterns }) => {
  const path = resolve(__dirname, file),
    original = fs.readFileSync(path, 'utf8')

  let content = original

  patterns.forEach((pattern) => {
    // Fail loudly, so a reworded header doesn't silently stop being bumped
    if (!pattern.test(content)) {
      console.error(`Version pattern ${pattern} not found in ${file}`)
      process.exit(1)
    }

    content = content.replace(pattern, (
      _match, before: string, after: unknown
    ) =>
      // `after` is the match offset (a number) when the pattern has only one group
      `${before}${version}${typeof after === 'string' ? after : ''}`)
  })

  if (content !== original) {
    fs.writeFileSync(path, content)
    console.info(`Updated ${file} to ${version}`)
  }
})
