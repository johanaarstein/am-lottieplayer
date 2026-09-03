// import { domain } from '@/utils/constants'
import { expect } from '@playwright/test'
import { test } from '@wordpress/e2e-test-utils-playwright'
// import { __ } from '@wordpress/i18n'

test.describe('dotLottiePlayer Element', () => {
  test.beforeAll(async ({ requestUtils }) => {
    await requestUtils.activateTheme('bricks')
  })

  // Wire up the WordPress test utilities
  test.beforeEach(async ({ admin, page }) => {
    await admin.createNewPost({ postType: 'page' })
    await page.locator('#toolbar-edit_with_bricks').click()
  })

  test('can insert Lottie Element', async ({ page }) => {
    const searchfield = page.locator('#bricks-panel-search')

    await searchfield.waitFor({ state: 'visible' })
    await searchfield.fill('AM LottiePlayer')

    const elementSelector = page.getByLabel('AM LottiePlayer')

    await expect(elementSelector).toBeVisible()
    await elementSelector.click()

    const placeholder = page.locator('.am-lottieplayer-placeholder').first()

    await expect(placeholder).toBeVisible()

    // await page.locator('.am-lottieplayer-placeholder').first().click()
    // await page.getByLabel(__('Animation', domain)).click()
  })
})