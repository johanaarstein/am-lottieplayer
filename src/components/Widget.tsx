import { __ } from '@wordpress/i18n'

import BoomerangLottie from '@/components/BoomerangLottie'

const domain = 'am-lottieplayer'

export default function Widget() {
  if (!aamdPHPVariables) {
    throw new Error('Missing variables')
  }

  const { pluginUrl } = aamdPHPVariables

  return (
    <div
      style={ {
        backgroundColor: '#22374a',
        color: '#FFF',
        overflow: 'hidden',
        padding: '1em 0',
      } }
    >
      <BoomerangLottie
        autoplay
        src={ `${ pluginUrl }assets/banner_top.lottie` }
      />
      <div style={ { margin: '1em' } }>
        <p>
          <strong>
            { __('Thank you for using AM LottiePlayer!',
              domain) }
          </strong>
        </p>
        <p>
          { __('We\'re proud to announce that we\'ve launched a premium version of this plugin with even more features – like combining & controlling animations in a single file, converting JSON to dotLottie and more.',
            domain) }
        </p>
        <a
          rel="noreferrer"
          style={ { color: '#d98f56' } }
          target="_blank"
          href={ __('https://www.aarstein.media/en/am-lottieplayer/pro',
            domain) }
        >
          { __('Read more about AM LottiePlayer PRO here!',
            domain) }
        </a>
      </div>
    </div>
  )
}
