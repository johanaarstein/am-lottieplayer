import type { BlockEditProps } from '@wordpress/blocks'

import {
  BaseControl,
  Panel,
  PanelBody,
  PanelRow,
  RangeControl,
} from '@wordpress/components'
import { useState } from '@wordpress/element'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import ProFeature from '@/assets/ProFeature'
import NumberInput from '@/components/form/NumberInput'
import SwitchLabel from '@/components/form/SwitchLabel'
import ProLink from '@/components/ProLink'
import { usePlayerContext } from '@/hooks/usePlayerContext'

const premiumMessage = __('This feature is only available in the premium version', 'am-lottieplayer')

export default function Animation({
  attributes,
  setAttributes,
}: Readonly<BlockEditProps<PlayerComponentProps>>) {
  const {
      autoplay, controls, direction, intermission, loop, segment, speed, subframe
    } = attributes,
    { animationContext: { animations, player } } = usePlayerContext(),
    [state] = useState(() => {
      const totalFrames = player?.getLottie()?.totalFrames ?? 0

      return {
        hasMultipleAnimations: animations.length > 1,
        totalFrames,
      }
    })

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={__('Animation Settings', 'am-lottieplayer')}
      >
        {state.hasMultipleAnimations &&
          <div style={{ marginBottom: '1em' }}>
            <p>
              <ProFeature />
            </p>
            <p>
              {__('This file contains multiple animations. To control each of them individually you need to upgrade to AM LottiePlayer PRO.',
                'am-lottieplayer')}
            </p>
          </div>
        }
        <SwitchLabel
          id="am-lottieplayer-controls-settings"
          title={__('Show controls', 'am-lottieplayer')}
          value={Boolean(controls)}
          onChange={(value) => { setAttributes({ controls: value }) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-autoplay-settings"
          title={__('Autoplay', 'am-lottieplayer')}
          value={Boolean(autoplay)}
          onChange={(value) => {
            setAttributes({ autoplay: value })
          }}
        />
        <SwitchLabel
          id="am-lottieplayer-loop-settings"
          title={__('Loop', 'am-lottieplayer')}
          value={Boolean(loop)}
          onChange={(value) => {
            setAttributes({ loop: value })
          }}
        />
        <SwitchLabel
          disabled
          id="am-lottieplayer-playmode-settings"
          title={
            <>
              <span
                className="pro-feature"
                style={{ marginRight: '1em' }}
              >
                {__('Boomerang', 'am-lottieplayer')}
              </span>
              <ProFeature />
            </>
          }
          onChange={() => { console.warn(premiumMessage) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-reverse-settings"
          title={__('Reverse', 'am-lottieplayer')}
          value={direction === -1}
          onChange={(value) => { setAttributes({ direction: value ? -1 : 1 }) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-subframe-settings"
          title={__('Subframe', 'am-lottieplayer')}
          value={Boolean(subframe)}
          subTitle={__('Makes the animation smoother, at the cost of RAM usage',
            'am-lottieplayer')}
          onChange={(value) => { setAttributes({ subframe: value }) }
          }
        />
        <RangeControl
          label={__('Speed', 'am-lottieplayer')}
          max={5}
          min={0.5}
          step={0.5}
          value={speed}
          onChange={(value) => { setAttributes({ speed: value }) }}
        />
        <BaseControl.VisualLabel>
          <p>
            <ProFeature />
          </p>
          <span className="pro-feature">
            {__('Play only part of the animation',
              'am-lottieplayer')}
          </span>
        </BaseControl.VisualLabel>
        <PanelRow className="lottie-segment">
          <NumberInput
            disabled
            id="am-lottieplayer-segment-in"
            placeholder={'1'}
            title={__('First frame', 'am-lottieplayer')}
            value={segment?.[0]}
            onChange={() => { console.warn(premiumMessage) }
            }
          />
          <NumberInput
            disabled
            id="am-lottieplayer-segment-out"
            placeholder={(state.totalFrames + 1).toString()}
            title={__('Last frame', 'am-lottieplayer')}
            value={segment?.[1]}
            onChange={() => { console.warn(premiumMessage) }
            }
          />
        </PanelRow>
        {Boolean(loop) &&
          <>
            <BaseControl.VisualLabel>
              {__('Intermission', 'am-lottieplayer')}
            </BaseControl.VisualLabel>
            <PanelRow className="lottie-intermission">
              <NumberInput
                id={'am-lottieplayer-intermission'}
                placeholder={'0'}
                value={intermission}
                title={__('Pause between loops, in miliseconds. 1s = 1000',
                  'am-lottieplayer')}
                onChange={(val) => { setAttributes({ intermission: val }) }
                }
              />
            </PanelRow>
          </>
        }
        <ProLink />
      </PanelBody>
    </Panel>
  )
}
