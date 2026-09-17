import {
  DIVI_TEXT_DOMAIN, getDiviFrame, getPostURL, insertModuleDivi, selectAttachmentFromModal
} from '@test/e2e/utils'
import { expect, test } from '@wordpress/e2e-test-utils-playwright'
import { __ } from '@wordpress/i18n'

test.describe('dotLottiePlayer Module', () => {
  test.beforeAll(async ({ requestUtils }) => {
    await requestUtils.activateTheme('Divi')
  })

  test.beforeEach(async ({
    admin, editor, page
  }) => {
    await admin.createNewPost({ postType: 'page' })
    await editor.canvas.locator('#et-switch-to-divi').click()

    const creationModal = page.locator('.et-vb-modal--page-creation')

    if (await creationModal.isVisible()) {
      await creationModal.locator('.et-vb-modal-header-button--close').click()
    }
    // For some reason this sometimes will pop up.
    const aiPrompt = page.locator('.et-common-prompt__container')

    if (await aiPrompt.isVisible()) {
      await aiPrompt.locator('[data-testid=ClosePrompt]').click()
    }
  })

  test.afterEach(async ({ requestUtils }) => {
    await requestUtils.deleteAllPages()
  })

  test('can insert Lottie Module', async ({ page }) => {
    const frame = getDiviFrame(page),
      placeholder = await insertModuleDivi(page, frame)

    await expect(placeholder).toBeVisible()
  })

  test('can configure and save Lottie Module', async ({ page }) => {
    const frame = getDiviFrame(page),
      placeholder = await insertModuleDivi(page, frame)

    await placeholder.click()

    await page.getByRole('button', { name: __('Upload', DIVI_TEXT_DOMAIN) }).click()

    await selectAttachmentFromModal(page)

    const controls = placeholder.locator('slot[name=controls]')

    await expect(controls).toBeVisible()

    await page.getByRole('button', { name: 'lottie-innerContent--controls' }).click()
    await expect(controls).toBeHidden()

    await page.getByRole('button', { name: __('Save Dropdown', DIVI_TEXT_DOMAIN) }).click()
    await page.getByRole('button', { name: __('Save & Publish', DIVI_TEXT_DOMAIN) }).click()

    await page.goto(getPostURL(page, 'page'))

    const player = page.locator('dotlottie-player')

    await expect(player).toBeVisible()
    await expect(player.locator('slot[name=controls]')).toBeHidden()
  })
})