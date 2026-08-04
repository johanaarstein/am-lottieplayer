import { defineConfig, devices } from '@playwright/test'
import { join } from 'node:path'

const STORAGE_STATE = join(process.cwd(),
  'artifacts/storage-states/admin.json')

export default defineConfig({
  fullyParallel: false, // wp-env is a single instance, keep this false
  globalSetup: require.resolve('./tests/e2e/global-setup'),
  projects: [
    {
      name: 'gutenberg',
      testMatch: '**/gutenberg/**/*.spec.ts',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
  reporter: 'html',
  retries: 1,
  testDir: './tests/e2e',
  use: {
    baseURL: 'http://localhost:8888',
    screenshot: 'only-on-failure',
    storageState: STORAGE_STATE,
    trace: 'retain-on-failure',
    video: 'retain-on-failure',
  },
  workers: 1,
})