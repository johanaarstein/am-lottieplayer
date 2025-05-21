import type { BlockEditProps } from '@wordpress/blocks'

import {
  BaseControl,
  Panel,
  PanelBody,
  PanelRow,
  RangeControl,
} from '@wordpress/components'
import { useEffect, useState } from '@wordpress/element'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import ProFeature from '@/assets/ProFeature'
import NumberInput from '@/components/form/NumberInput'
import SwitchLabel from '@/components/form/SwitchLabel'
import ProLink from '@/components/ProLink'
import { usePlayerContext } from '@/context/PlayerWrapper'

const domain = 'am-lottieplayer',
  premiumMessage = __('This feature is only available in the premium version', domain)

const Animation = ({
  attributes,
  setAttributes,
}: BlockEditProps<PlayerComponentProps>) => {
  const {
      autoplay, controls, direction, intermission, loop, segment, speed, subframe
    } = attributes,
    { animationContext: { animations = [], player } } = usePlayerContext(),
    [state, setState] = useState({
      hasMultipleAnimations: false,
      totalFrames: 0,
    })

  useEffect(() => {
    if (player) {
      setState({
        hasMultipleAnimations: animations.length > 1,
        totalFrames: Number(player.getLottie()?.totalFrames ?? 0),
      })
    }
  }, [animations.length, player])

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={__('Animation Settings', domain)}
      >
        {state.hasMultipleAnimations &&
          <div style={{ marginBottom: '1em' }}>
            <p>
              <ProFeature />
            </p>
            <p>
              {__('This file contains multiple animations. To control each of them individually you need to upgrade to AM LottiePlayer PRO.',
                domain)}
            </p>
          </div>
        }
        <SwitchLabel
          id="am-lottieplayer-controls-settings"
          title={__('Show controls', domain)}
          value={Boolean(controls)}
          onChange={(value) =>
          { setAttributes({ controls: value }) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-autoplay-settings"
          title={__('Autoplay', domain)}
          value={Boolean(autoplay)}
          onChange={(value) => {
            setAttributes({ autoplay: value })
          }}
        />
        <SwitchLabel
          id="am-lottieplayer-loop-settings"
          title={__('Loop', domain)}
          value={Boolean(loop)}
          onChange={(value) => {
            setAttributes({ loop: value })
          }}
        />
        <SwitchLabel
          disabled
          id="am-lottieplayer-playmode-settings"
          value={false}
          title={
            <>
              <span
                className="pro-feature"
                style={{ marginRight: '1em' }}
              >
                {__('Boomerang', domain)}
              </span>
              <ProFeature />
            </>
          }
          onChange={() =>
          { console.warn(premiumMessage) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-reverse-settings"
          title={__('Reverse', domain)}
          value={direction === -1}
          onChange={(value) =>
          { setAttributes({ direction: value ? -1 : 1 }) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-subframe-settings"
          title={__('Subframe', domain)}
          value={Boolean(subframe)}
          subTitle={__('Makes the animation smoother, at the cost of RAM usage',
            domain)}
          onChange={(value) =>
          { setAttributes({ subframe: value }) }
          }
        />
        <RangeControl
          label={__('Speed', domain)}
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
              domain)}
          </span>
        </BaseControl.VisualLabel>
        <PanelRow className="lottie-segment">
          <NumberInput
            disabled
            id="am-lottieplayer-segment-in"
            placeholder={'1'}
            title={__('First frame', domain)}
            value={segment?.[0]}
            onChange={() =>
            { console.warn(premiumMessage) }
            }
          />
          <NumberInput
            disabled
            id="am-lottieplayer-segment-out"
            placeholder={(state.totalFrames + 1).toString()}
            title={__('Last frame', domain)}
            value={segment?.[1]}
            onChange={() =>
            { console.warn(premiumMessage) }
            }
          />
        </PanelRow>
        {Boolean(loop) &&
          <>
            <BaseControl.VisualLabel>
              {__('Intermission', domain)}
            </BaseControl.VisualLabel>
            <PanelRow className="lottie-intermission">
              <NumberInput
                id={'am-lottieplayer-intermission'}
                placeholder={'0'}
                value={intermission}
                title={__('Pause between loops, in miliseconds. 1s = 1000',
                  domain)}
                onChange={(val) =>
                { setAttributes({ intermission: val }) }
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

export default Animation
