/* eslint-disable @eslint-react/no-leaked-conditional-rendering */

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

const domain = 'am-lottieplayer'

export default function Interactions ( {
  attributes,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={ __( 'Interactions', domain ) }
      >
        <SwitchLabel
          disabled
          id={ 'am-lottieplayer-animateOnScroll-settings' }
          value={ false }
          title={
            <>
              <span
                className="pro-feature"
                style={ { marginRight: '1em' } }
              >
                { __( 'Animate on scroll', domain ) }
              </span>
              <ProFeature />
            </>
          }
          onChange={ () =>
          { console.warn('This feature is only available in the premium version') }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-click-settings"
          title={ __( 'Play on click', domain ) }
          value={ Boolean(attributes.playOnClick) }
          onChange={ ( value ) =>
          { setAttributes({ playOnClick: value } ) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-hover-settings"
          title={ __( 'Play on mouseover', domain ) }
          value={Boolean(attributes.hover) }
          onChange={ ( value ) => { setAttributes( { hover: value } ) } }
        />
        { attributes.hover &&
          <SelectControl
            label={ __( 'On mouseout', domain ) }
            value={ attributes.mouseout }
            options={ [
              {
                label: __( 'No event', domain ),
                value: MouseOut.Void,
              },
              {
                label: __( 'Stop', domain ),
                value: MouseOut.Stop,
              },
              {
                label: __( 'Pause', domain ),
                value: MouseOut.Pause,
              },
              {
                label: __( 'Reverse', domain ),
                value: MouseOut.Reverse,
              },
            ] }
            onChange={ ( val ) =>
            { setAttributes( { mouseout: val as MouseOut } ) }
            }
          />
        }
        { ( attributes.hover || attributes.playOnClick ) &&
          <>
            <TextInput
              disabled
              id="am-lottieplayer-settings"
              placeholder={ '#' }
              value={ attributes.selector }
              help={ __('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.',
                domain) }
              title={
                <>
                  <span
                    className="pro-feature"
                    style={ { marginRight: '1em' } }
                  >
                    { __('Trigger element',
                      domain) }
                  </span>

                  <ProFeature />
                </>
              }
              onChange={ ( val ) =>
              { setAttributes( { selector: val } ) }
              }
            />
            {/* <SwitchLabel
              disabled
              id="am-lottieplayer-selector-settings"
              value={ selector?.exclude }
              title={
                <>
                  <span
                    className="pro-feature"
                    style={ {
                      display: 'block',
                      marginBottom: '1em',
                    } }
                  >
                    { __('Apply interaction only to trigger element',
                      domain) }
                  </span>
                  <ProFeature />
                </>
              }
              onChange={ ( val ) =>
              { setAttributes( {
                selector: {
                  ...selector,
                  exclude: val
                },
              } ) }
              }
            /> */}
          </>
        }
        <SwitchLabel
          id="am-lottieplayer-scroll-settings"
          value={ Boolean(attributes.playOnVisible) }
          title={ __('Play on scroll, when visible in viewport',
            domain) }
          onChange={ ( value ) =>
          { setAttributes( { playOnVisible: value } ) }
          }
        />
        { attributes.playOnVisible &&
          <>
            <SwitchLabel
              id="am-lottieplayer-once-settings"
              title={ __( 'Play only once', domain ) }
              value={ attributes.once }
              onChange={ ( value ) =>
              { setAttributes( { once: value } ) }
              }
            ></SwitchLabel>
            <RangeControl
              max={ 50 }
              min={ 0 }
              step={ 1 }
              value={ attributes.delay ?? 1 }
              label={ __('Delay, in 10th of a second',
                domain) }
              onChange={ ( value ) =>
              { setAttributes( { delay: value } ) }
              }
            />
          </>
        }
        <ProLink />
      </PanelBody>
    </Panel>
  )
}