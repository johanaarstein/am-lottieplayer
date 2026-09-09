import { defineConfig, devices } from '@playwright/test'
import { dirname, join, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import dotenv from 'dotenv'

const STORAGE_STATE = join(process.cwd(),
  'artifacts/storage-states/admin.json'),
  __dirname = dirname(fileURLToPath(import.meta.url))

dotenv.config({ path: resolve(__dirname, '.env.local') })

process.env.STORAGE_STATE_PATH = process.env.STORAGE_STATE_PATH ?? STORAGE_STATE

export default defineConfig({
  fullyParallel: false, // wp-env is a single instance, keep this false
  globalSetup: resolve(__dirname, 'tests', 'global.setup.ts'),
  projects: [
    {
      name: 'gutenberg',
      testMatch: '**/gutenberg/**/*.spec.ts',
      use: { ...devices['Desktop Chrome'] }
    },
    {
      name: 'bricks',
      testMatch: '**/bricks/**/*.spec.ts',
      use: { ...devices['Desktop Chrome'] }
    },
    {
      name: 'divi',
      testMatch: '**/divi/**/*.spec.ts',
      use: { ...devices['Desktop Chrome'] }
    },
    {
      name: 'elementor',
      testMatch: '**/elementor/**/*.spec.ts',
      use: { ...devices['Desktop Chrome'] }
    },
  ],
  reporter: 'html',
  retries: 1,
  testDir: './tests/e2e',
  use: {
    baseURL: process.env.WP_BASE_URL ?? 'http://localhost:8888',
    screenshot: 'only-on-failure',
    storageState: STORAGE_STATE,
    trace: 'retain-on-failure',
    video: 'retain-on-failure',
  },
  webServer: [{
    command: 'pnpm exec wp-scripts build --config webpack.config.ts && pnpm exec wp-env start',
    ignoreHTTPSErrors: true,
    reuseExistingServer: !process.env.CI,
    timeout: 180_000,
    url: 'http://localhost:8888'
  }, { command: 'open -a Docker' }],
  workers: 1,
})