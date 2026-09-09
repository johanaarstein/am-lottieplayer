import {
  ELEMENTOR_TEXT_DOMAIN,
  getElementorFrame,
  getPostURL,
  insertWidgetElementor,
  selectAttachmentFromModal
} from '@test/e2e/utils'
import { expect, test } from '@wordpress/e2e-test-utils-playwright'
import { __ } from '@wordpress/i18n'

test.describe('dotlottiePlayer Widget', () => {
  test.beforeAll(async ({ requestUtils }) => {
    await requestUtils.activateTheme('twentytwentyfive')
    await requestUtils.activatePlugin('elementor')
  })

  test.beforeEach(async ({ admin, page }) => {
    await admin.createNewPost({ postType: 'page' })
    const patternDialog = page.getByRole('dialog', { name: __('Choose a pattern', ELEMENTOR_TEXT_DOMAIN) })
    if (await patternDialog.isVisible()) {
      await patternDialog.getByRole('button', { name: __('Close', ELEMENTOR_TEXT_DOMAIN)}).click()
    }

    await page.locator('#elementor-switch-mode-button').click()
  })

  test.afterEach(async ({ requestUtils }) => {
    await requestUtils.deleteAllPages()
  })

  test('can insert Lottie Widget', async ({ page }) => {
    const frame = getElementorFrame(page),
      placeholder = await insertWidgetElementor(page, frame)

    await expect(placeholder).toBeVisible()
  })

  test('can configure and save Lottie Widget', async ({ page }) => {
    const frame = getElementorFrame(page)

    await insertWidgetElementor(page, frame)
    await page.locator(`div[data-tooltip="${__('Upload', ELEMENTOR_TEXT_DOMAIN)}"]`).click()
    await selectAttachmentFromModal(page)

    const dotLottiePlayer = frame.locator('dotlottie-player').first()

    await expect(dotLottiePlayer.locator('.error')).toBeHidden()

    const controls = dotLottiePlayer.locator('slot[name=controls]')

    await expect(dotLottiePlayer).toBeVisible()
    await expect(controls).toBeVisible()

    await page.locator('div.elementor-control-controls .elementor-switch').click()
    await expect(controls).toBeHidden()

    const publishButton = page.getByRole('button', { name: __('Publish', ELEMENTOR_TEXT_DOMAIN) })

    await expect(publishButton).toBeEnabled()
    await publishButton.click()
    await expect(publishButton).toBeDisabled()

    // Elementor treats pages as posts, when it comes to url pattern.
    await page.goto(getPostURL(page))

    const player = page.locator('dotlottie-player')

    await expect(player).toBeVisible()
    await expect(player.locator('slot[name=controls]')).toBeHidden()
  })
})