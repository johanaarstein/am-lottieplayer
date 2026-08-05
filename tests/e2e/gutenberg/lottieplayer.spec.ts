import { expect } from '@playwright/test'
import { test } from '@wordpress/e2e-test-utils-playwright'


test.describe('dotLottiePlayer Block', () => {
  // Wire up the WordPress test utilities
  test.beforeEach(async ({ admin }) => {
    await admin.createNewPost()
  })

  test('can insert Lottie block', async ({ editor }) => {
    await editor.insertBlock({ name: 'gb/lottieplayer' })

    // Assert the block appeared in the editor
    const block = editor.canvas.getByLabel('Block: AM LottiePlayer')

    await expect(block).toBeVisible()
  })

  test('can configure and save a Lottie block', async ({ editor, page }) => {
    await editor.insertBlock({ name: 'gb/lottieplayer' })

    // Open block settings and configure — adjust selectors to match your UI
    const block = editor.canvas.getByLabel('Block: AM LottiePlayer')

    // Select AM LottiePlayer Block
    await block.click()

    // Add external URL
    await block.getByPlaceholder('Paste URL or type to search').fill('https://storage.googleapis.com/aarsteinmedia/am.lottie')

    // Save the post
    await editor.publishPost()

    // Visit the frontend and assert the player element is present
    const postUrl = await page.evaluate(() =>
      // eslint-disable-next-line @typescript-eslint/no-unsafe-return, @typescript-eslint/no-unsafe-call
      wp.data.select('core/editor').getPermalink()) as string

    await page.goto(postUrl)

    // Adjust this selector to match your plugin's frontend output
    await expect(page.locator('.am-lottie-player, dotlottie-player')).toBeVisible()
  })
})