import fs from 'node:fs'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'

import type pkg from './package.json'

const __dirname = dirname(fileURLToPath(import.meta.url))

const dependencies = [
  {
    dest: 'dotlottie-player-light.min.js',
    handle: 'dotlottie-player-light',
    name: '@aarsteinmedia/dotlottie-player',
    src: 'dist/unpkg-light.js'
  }
]

const destDir = resolve(__dirname, 'scripts')

if (!fs.existsSync(destDir)) {
  fs.mkdirSync(destDir, { recursive: true })
}

interface Manifest {
  [key: string]: {
    file: string
    version: string
  }
}

const manifest: Manifest = {}

dependencies.forEach(({
  dest,
  handle,
  name,
  src
}) => {
  const pkgDir = resolve(
    __dirname, 'node_modules', name
  )
  const pkgJsonPath = resolve(pkgDir, 'package.json')

  if (!fs.existsSync(pkgJsonPath)) {
    console.error(`Package ${name} not found. Run pnpm install first.`)

    process.exit(1)
  }

  // Read package.json to extract SemVer
  const pkgJson: typeof pkg = JSON.parse(fs.readFileSync(pkgJsonPath, 'utf8')),

    // Copy script file
    srcPath = resolve(pkgDir, src),
    destPath = resolve(destDir, dest)

  fs.copyFileSync(srcPath, destPath)

  // Store metadata in manifest
  manifest[handle] = {
    file: dest,
    version: pkgJson.version,
  }
})

// Write the manifest to your plugin directory
fs.writeFileSync(resolve(__dirname, 'scripts/vendor-manifest.json'),
  JSON.stringify(
    manifest, null, 2
  ))

console.info('Assets copied and vendor-manifest.json generated.')