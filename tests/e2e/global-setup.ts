import { request, type FullConfig } from '@playwright/test'
import { RequestUtils } from '@wordpress/e2e-test-utils-playwright'

export default async function globalSetup({ projects }: FullConfig) {
  const { baseURL, storageState } = projects[0].use,
    storageStatePath = typeof storageState === 'string' ? storageState : undefined,

    requestContext = await request.newContext({ baseURL }),
    requestUtils = new RequestUtils(requestContext, {
      storageStatePath,
      user: {
        password: process.env.WP_PASSWORD ?? 'password',
        username: process.env.WP_USERNAME ?? 'admin'
      }
    })

  await requestUtils.setupRest()
  await requestContext.dispose()
}