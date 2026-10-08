import { request, type FullConfig } from '@playwright/test'
import { RequestUtils } from '@wordpress/e2e-test-utils-playwright'

const NONCE_PATTERN = /^[a-f0-9]+$/,
  NONCE_RETRIES = 5

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

  // Plugin activation redirects hook `admin_init`, which `admin-ajax.php` fires
  // too, so the nonce request can resolve to an admin page. They are one-shot,
  // so a retry gets the real nonce.
  let restState = await requestUtils.setupRest()

  for (let i = 0; i < NONCE_RETRIES && !NONCE_PATTERN.test(restState.nonce); i++) {
    restState = await requestUtils.setupRest()
  }

  await requestContext.dispose()

  if (!NONCE_PATTERN.test(restState.nonce)) {
    throw new Error(`Could not acquire a REST nonce from ${baseURL}: got ${restState.nonce.length} characters of non-nonce content.`)
  }
}