import { expect } from '@playwright/test'
import {
 getBricksFrame, getPostURL, insertElementBricks,
 selectAttachmentFromModal
} from '@test/e2e/utils'
import { test } from '@wordpress/e2e-test-utils-playwright'

test.describe('dotLottiePlayer Element', () => {
  test.beforeAll(async ({ requestUtils }) => {
    await requestUtils.activateTheme('bricks')
  })

  // Wire up the WordPress test utilities
  test.beforeEach(async ({ admin, page }) => {
    await admin.createNewPost({ postType: 'page' })
    await page.locator('#toolbar-edit_with_bricks').click()
  })

  test.afterEach(async ({ requestUtils }) => {
    // await deletePost(page, requestUtils)
    await requestUtils.deleteAllPages()
  })

  test('can insert Lottie Element', async ({ page }) => {
    const frame = getBricksFrame(page),
      placeholder = await insertElementBricks(page, frame)

    await expect(placeholder).toBeVisible()
  })

  test('can configure and save a Lottie Element', async ({ page }) => {
    const frame = getBricksFrame(page),
      placeholder = await insertElementBricks(page, frame)

    await placeholder.click()

    // await page.getByText(__('Animation', domain)).click()
    await page.locator('[data-control-group=animation]').click()
    await page.getByRole('button', { name: 'Select file' }).click()

    await selectAttachmentFromModal(page)

    const dotLottiePlayer = frame.locator('dotlottie-player').first(),
      controls = dotLottiePlayer.locator('slot[name=controls]')

    await expect(dotLottiePlayer).toBeVisible()
    await expect(controls).toBeVisible()

    await page.locator('#controls').click()
    await expect(controls).toBeHidden()

    await page.locator('[data-balloon="Save draft"]').click()
    await page.locator('[data-balloon=Publish]').click()

    await page.goto(getPostURL(page, 'page'))

    const player = page.locator('dotlottie-player')

    await expect(player).toBeVisible()
    await expect(player.locator('slot[name=controls]')).toBeHidden()
  })
})