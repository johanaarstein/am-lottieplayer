import { __ } from '@wordpress/i18n'

import { domain } from '@/utils/constants'

export default function ProFeature() {
  return (
    <a
      rel="noreferrer"
      target="_blank"
      href={__('https://www.aarstein.media/en/am-lottieplayer/pro',
        domain)}
      style={{
        backgroundColor: 'var(--wp-admin-theme-color)',
        borderRadius: '1.5em',
        color: 'white',
        display: 'inline-block',
        fontSize: '.75rem',
        padding: '.5em 1em',
        textDecoration: 'none',
        textTransform: 'none',
      }}
    >
      <strong>PRO</strong> {__('feature', domain)}
    </a>
  )
}
