import { defineConfig, devices } from '@playwright/test'

export default defineConfig({
  fullyParallel: false, // wp-env is a single instance, keep this false
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
    baseURL: 'http://localhost:8889',
    screenshot: 'only-on-failure',
    trace: 'retain-on-failure',
    video: 'retain-on-failure',
  },
  workers: 1,
})