import type { RequestUtils } from '@wordpress/e2e-test-utils-playwright'

import { expect, type Page } from '@playwright/test'
import { __ } from '@wordpress/i18n'

import { domain } from '@/utils/constants'

type PostType = 'post' | 'page'

export const getPostId = (page: Page, postType: PostType = 'post') => {
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
  insertElementBricks = async (page: Page) => {
    const searchfield = page.locator('#bricks-panel-search')

    await searchfield.waitFor({ state: 'visible' })
    await searchfield.fill('AM LottiePlayer')

    const elementSelector = page.locator('div.element-label[title="AM LottiePlayer"]')

    await expect(elementSelector).toBeVisible()
    await elementSelector.click()

    const frame = getBricksFrame(page),
      placeholder = frame.getByText(__('No Lottie selected', domain))

    return placeholder
  }