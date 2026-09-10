import type { FrameLocator, Page } from '@playwright/test'

import { expect, type RequestUtils } from '@wordpress/e2e-test-utils-playwright'
import { __ } from '@wordpress/i18n'

export const DIVI_TEXT_DOMAIN = 'Divi',
  BRICKS_TEXT_DOMAIN = 'bricks',
  ELEMENTOR_TEXT_DOMAIN = 'elementor'

type PostType = 'post' | 'page'

export const handleBricksLicense = async (page: Page) => {
  const activateButton = page.getByRole('button', { name: __('Activate license', BRICKS_TEXT_DOMAIN) })

  if (await activateButton.isHidden()) {
    return
  }

  if (await page.locator('.status.no_license').isVisible()) {
    await page.getByRole('button', { name: __('Deactivate license', BRICKS_TEXT_DOMAIN) }).click()
  }
  await page.locator('[type=password]').fill(process.env.BRICKS_LICENSE ?? '')
  await activateButton.click()
},
  getPostId = (page: Page, postType: PostType = 'post') => {
    const { searchParams } = new URL(page.url())

    let param: string = postType

    if (postType === 'page') {
      param = 'page_id'
    }

    return searchParams.get(param)
  },
  getPostURL = (page: Page, postType: PostType = 'post') => {
    const { origin } = new URL(page.url())

    return `${origin}?p=${getPostId(page, postType)}`
  },
  deletePost = async (
    page: Page, requestUtils: RequestUtils, postType: PostType = 'post'
  ) => {
    const postId = getPostId(page)

    if (!postId) {
      return
    }

    await requestUtils.rest({
      method: 'DELETE',
      path: `/wp/v2/${postType}s/${postId}`
    })
  },
  getBricksFrame = (page: Page) => {
    return page.frameLocator('#bricks-builder-iframe')
  },
  getDiviFrame = (page: Page) => {
    return page.frameLocator('#et-vb-app-frame')
  },
  getElementorFrame = (page: Page) => {
    return page.frameLocator('#elementor-preview-iframe')
  },
  insertElementBricks = async (page: Page, frame: FrameLocator) => {
    const searchfield = page.locator('#bricks-panel-search')

    await searchfield.waitFor({ state: 'visible' })
    await searchfield.fill('AM LottiePlayer')

    const elementSelector = page.locator('li.bricks-add-element[data-element-name=am-lottieplayer]')

    await expect(elementSelector).toBeVisible()
    await elementSelector.click()

    const placeholder = frame.getByText(__('No Lottie selected', 'am-lottieplayer'))

    return placeholder
  },
  insertModuleDivi = async (page: Page, frame: FrameLocator) => {
    await frame.getByRole('button', { name: __('Add row', DIVI_TEXT_DOMAIN) }).click()

    const modal = page.locator('.et-vb-modal--add-module')

    await expect(modal).toBeVisible()
    await modal.getByRole('button', { name: 'equal-columns_1' }).click()

    const searchfield = modal.locator('#et-vb-field-input-text-filter-option')

    await searchfield.waitFor({ state: 'visible' })
    await searchfield.fill('AM Lottie')

    const moduleSelector = modal.getByRole('button', { name: 'AM Lottie' })

    await expect(moduleSelector).toBeVisible()
    await moduleSelector.click()

    const placeholder = frame.locator('dotlottie-player')

    await expect(placeholder.locator('.error')).toBeHidden()

    return placeholder
  },
  insertWidgetElementor = async (page: Page, frame: FrameLocator) => {
    const searchfield = page.locator('#elementor-panel-elements-search-input')

    await searchfield.waitFor({ state: 'visible' })
    await searchfield.fill('AM Lottie')

    const widgetSelector = page.getByRole('button', { name: 'AM LottiePlayer' })

    await expect(widgetSelector).toBeVisible()
    await widgetSelector.click()

    return frame.locator('div.elementor-widget-am_lottieplayer_widget.elementor-widget-empty')
  },
  selectAttachmentFromModal = async (page: Page, id?: number) => {
    const uploadDialog = page.locator('#wp-media-modal'),
      insertButton = uploadDialog.locator('button.media-button')

    await expect(uploadDialog).toBeVisible()

    if (id) {
      await uploadDialog.locator(`[data-id=${id}`).click()
    } else {
      await uploadDialog.locator('.attachment.save-ready').first().click()
    }

    await expect(insertButton).toBeEnabled()

    await insertButton.click()
  }