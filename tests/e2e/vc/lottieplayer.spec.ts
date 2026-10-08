import {
  getPostURL,
  getVCFrame, insertElementVC, selectAttachmentFromModal
} from '@test/e2e/utils'
import { expect, test } from '@wordpress/e2e-test-utils-playwright'


test.describe('dotLottiePlayer Element', () => {
  test.beforeAll(async ({ requestUtils }) => {
    await requestUtils.activateTheme('twentytwentyfive')
    await requestUtils.activatePlugin('js_composer')
  })

  test.beforeEach(async ({ admin, page }) => {
    await admin.createNewPost({ postType: 'page' })
    await page.locator('.wpb_switch-to-composer').click()

    const promoPopup = page.locator('#vc_ui-helper-promo-popup')

    if (await promoPopup.isVisible()) {
      await promoPopup.locator('.vc_ui-close-button').click()
    }

    // Enable Front-end editor.
    await page.locator('.wpb_switch-to-front-composer').click()
    await page.locator('.vc_post-custom-layout').first().click()
  })

  test.afterEach(async ({ requestUtils }) => {
    await requestUtils.deleteAllPosts()
  })

  test('can insert Lottie element', async ({ page }) => {
    const vcFrame = getVCFrame(page),
      placeholder = await insertElementVC(page, vcFrame)

    await expect(placeholder).toBeVisible()
  })

  test('can configure and save a Lottie block', async ({ page }) => {
    const vcFrame = getVCFrame(page)

    await insertElementVC(page, vcFrame)

    const modal = page.locator('#vc_ui-panel-edit-element')

    await expect(modal).toBeVisible()
    await modal.locator('#attach_src-button').click()
    await selectAttachmentFromModal(page)

    await modal.locator('[data-vc-ui-element="button-save"]').click()
    await modal.locator('[data-vc-ui-element="button-close"]').click()

    await page.locator('#vc_button-update').click()
    await page.goto(getPostURL(page, 'page'))

    const player = page.locator('dotlottie-player')

    await expect(player).toBeVisible()
    await expect(player.locator('slot[name=controls]')).toBeHidden()
  })
})