import { expect, test } from '@playwright/test'
import { execFileSync } from 'node:child_process'
import { resolve } from 'node:path'

interface OptionRow {
  option_name: string
  option_value: string
}

const PLUGIN = 'am-lottieplayer-pro',
  OPTION_PREFIX = 'am_lottieplayer_pro_',
  DEFAULT_ANIMATION_OPTION = 'aamd_default_lottie_animation',
  // Run the project's wp-env with this Node binary, rather than looking either up on PATH.
  WP_ENV = resolve(
    process.cwd(), 'node_modules', '@wordpress', 'env', 'bin', 'wp-env'
  ),

  /**
   * Run a WP-CLI command in the wp-env cli container and return its stdout.
   * wp-env passes args through to `docker compose exec` as an array, and writes
   * its spinner to stderr, so stdout is the command output only.
   */
  wp = (...args: string[]) => execFileSync(
    process.execPath,
    [
      WP_ENV,
      'run',
      'cli',
      'wp',
      ...args
    ],
    {
      encoding: 'utf8',
      stdio: [
        'ignore',
        'pipe',
        'pipe'
      ]
    }
  ).trim(),

  /**
   * Names of options matching a `wp option list --search` pattern.
   * Transients are stored as options too (wp-env has no object cache).
   */
  listOptions = (search: string) => {
    const lines = wp(
        'option',
        'list',
        `--search=${search}`,
        '--fields=option_name,option_value',
        '--format=json'
      ).split('\n'),
      rows = JSON.parse(lines.at(-1) ?? '[]') as OptionRow[]

    return rows
  },

  /** Whether a post with the given ID exists. `wp post exists` exits 1 if not. */
  postExists = (id: string) => {
    try {
      wp(
        'post', 'exists', id
      )

      return true
    } catch {
      return false
    }
  }

test.describe('uninstall.php', () => {
  let attachmentId = '',
    savedOptions: OptionRow[] = []

  test.beforeAll(() => {
    // Keep the dev site's real settings (e.g. the license key) so they can be restored.
    savedOptions = listOptions(`${OPTION_PREFIX}*`)

    wp(
      'option', 'update', `${OPTION_PREFIX}license`, 'e2e-test-key'
    )
    wp(
      'option', 'update', `${OPTION_PREFIX}load_light`, '1'
    )
    wp(
      'option', 'update', `${OPTION_PREFIX}license_activated`, '1'
    )
    wp(
      'transient', 'set', `${OPTION_PREFIX}updates`, 'cached', '3600'
    )
    wp(
      'transient', 'set', `${OPTION_PREFIX}info`, 'cached', '3600'
    )

    // A bare attachment post stands in for the sideloaded default animation.
    attachmentId = wp(
      'post',
      'create',
      '--post_type=attachment',
      '--post_title=AM Lottie e2e default animation',
      '--porcelain'
    ).split('\n').at(-1) ?? ''

    wp(
      'option', 'update', DEFAULT_ANIMATION_OPTION, attachmentId
    )

    // Sanity check the seed, so a passing test means uninstall removed something.
    expect(listOptions(`*${OPTION_PREFIX}*`).length).toBeGreaterThanOrEqual(5)
  })

  test.afterAll(() => {
    wp(
      'plugin', 'activate', PLUGIN
    )

    for (const { option_name, option_value } of savedOptions) {
      wp(
        'option', 'update', option_name, option_value
      )
    }

    if (attachmentId && postExists(attachmentId)) {
      wp(
        'post', 'delete', attachmentId, '--force'
      )
    }
  })

  test('removes options, transients and the default animation', () => {
    // --skip-delete is essential: wp-env mounts this repo as the plugin
    // directory, so a full uninstall would delete the working tree.
    wp(
      'plugin', 'uninstall', PLUGIN, '--deactivate', '--skip-delete'
    )

    expect(listOptions(`*${OPTION_PREFIX}*`)).toEqual([])
    expect(listOptions(DEFAULT_ANIMATION_OPTION)).toEqual([])
    expect(postExists(attachmentId)).toBe(false)
  })
})
