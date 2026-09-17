
import type { BlockEditProps } from '@wordpress/blocks'

import {
  Panel,
  PanelBody,
  RangeControl,
  SelectControl,
} from '@wordpress/components'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import ProFeature from '@/assets/ProFeature'
import SwitchLabel from '@/components/form/SwitchLabel'
import TextInput from '@/components/form/TextInput'
import ProLink from '@/components/ProLink'
import { MouseOut } from '@/enums'

export default function Interactions({
  attributes,
  setAttributes,
}: Readonly<BlockEditProps<PlayerComponentProps>>) {

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={__('Interactions', 'am-lottieplayer')}
      >
        <SwitchLabel
          disabled
          id={'am-lottieplayer-animateOnScroll-settings'}
          title={
            <>
              <span
                className="pro-feature"
                style={{ marginRight: '1em' }}
              >
                {__('Animate on scroll', 'am-lottieplayer')}
              </span>
              <ProFeature />
            </>
          }
          onChange={() => { console.warn('This feature is only available in the premium version') }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-click-settings"
          title={__('Play on click', 'am-lottieplayer')}
          value={Boolean(attributes.playOnClick)}
          onChange={(value) => { setAttributes({ playOnClick: value }) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-hover-settings"
          title={__('Play on mouseover', 'am-lottieplayer')}
          value={Boolean(attributes.hover)}
          onChange={(value) => { setAttributes({ hover: value }) }}
        />
        {attributes.hover &&
          <SelectControl
            label={__('On mouseout', 'am-lottieplayer')}
            value={attributes.mouseout}
            options={[
              {
                label: __('No event', 'am-lottieplayer'),
                value: MouseOut.Void,
              },
              {
                label: __('Stop', 'am-lottieplayer'),
                value: MouseOut.Stop,
              },
              {
                label: __('Pause', 'am-lottieplayer'),
                value: MouseOut.Pause,
              },
              {
                label: __('Reverse', 'am-lottieplayer'),
                value: MouseOut.Reverse,
              },
            ]}
            onChange={(val) => { setAttributes({ mouseout: val }) }
            }
          />
        }
        {(attributes.hover || attributes.playOnClick) &&
          <TextInput
            disabled
            id="am-lottieplayer-settings"
            placeholder={'#'}
            value={attributes.selector}
            help={__('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.',
              'am-lottieplayer')}
            title={
              <>
                <span
                  className="pro-feature"
                  style={{ marginRight: '1em' }}
                >
                  {__('Trigger element',
                    'am-lottieplayer')}
                </span>

                <ProFeature />
              </>
            }
            onChange={(val) => { setAttributes({ selector: val }) }
            }
          />
        }
        <SwitchLabel
          id="am-lottieplayer-scroll-settings"
          value={Boolean(attributes.playOnVisible)}
          title={__('Play on scroll, when visible in viewport',
            'am-lottieplayer')}
          onChange={(value) => { setAttributes({ playOnVisible: value }) }
          }
        />
        {attributes.playOnVisible &&
          <>
            <SwitchLabel
              id="am-lottieplayer-once-settings"
              title={__('Play only once', 'am-lottieplayer')}
              value={attributes.once}
              onChange={(value) => { setAttributes({ once: value }) }
              }
            ></SwitchLabel>
            <RangeControl
              max={50}
              min={0}
              step={1}
              value={attributes.delay ?? 1}
              label={__('Delay, in 10th of a second',
                'am-lottieplayer')}
              onChange={(value) => { setAttributes({ delay: value }) }
              }
            />
          </>
        }
        <ProLink />
      </PanelBody>
    </Panel>
  )
}