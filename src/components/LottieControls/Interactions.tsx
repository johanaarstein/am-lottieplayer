/* eslint-disable @typescript-eslint/naming-convention */
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
import { OnMouseOut } from '@/enums'

const domain = 'am-lottieplayer'

export default function Interactions ( {
  attributes,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const {
    clickEvent,
    hover,
    mouseout,
    once,
    scrollDelay,
    scrollEvent,
    selector,
  } = attributes

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
          value={ clickEvent }
          onChange={ ( value ) =>
          { setAttributes( { clickEvent: value } ) }
          }
        />
        <SwitchLabel
          id="am-lottieplayer-hover-settings"
          title={ __( 'Play on mouseover', domain ) }
          value={ hover }
          onChange={ ( value ) => { setAttributes( { hover: value } ) } }
        />
        { hover &&
          <SelectControl
            label={ __( 'On mouseout', domain ) }
            value={ mouseout }
            options={ [
              {
                label: __( 'No event', domain ),
                value: OnMouseOut.Void,
              },
              {
                label: __( 'Stop', domain ),
                value: OnMouseOut.Stop,
              },
              {
                label: __( 'Pause', domain ),
                value: OnMouseOut.Pause,
              },
              {
                label: __( 'Reverse', domain ),
                value: OnMouseOut.Reverse,
              },
            ] }
            onChange={ ( val ) =>
            { setAttributes( { mouseout: val as OnMouseOut } ) }
            }
          />
        }
        { ( hover || clickEvent ) &&
          <>
            <TextInput
              disabled
              id="am-lottieplayer-settings"
              placeholder={ '#' }
              value={ selector?.id }
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
              { setAttributes( {
                selector: {
                  ...selector,
                  id: val
                },
              } ) }
              }
            />
            <SwitchLabel
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
            />
          </>
        }
        <SwitchLabel
          id="am-lottieplayer-scroll-settings"
          value={ scrollEvent }
          title={ __('Play on scroll, when visible in viewport',
            domain) }
          onChange={ ( value ) =>
          { setAttributes( { scrollEvent: value } ) }
          }
        />
        { scrollEvent &&
          <>
            <SwitchLabel
              id="am-lottieplayer-once-settings"
              title={ __( 'Play only once', domain ) }
              value={ once }
              onChange={ ( value ) =>
              { setAttributes( { once: value } ) }
              }
            ></SwitchLabel>
            <RangeControl
              max={ 50 }
              min={ 0 }
              step={ 1 }
              value={ scrollDelay ?? 1 }
              label={ __('Delay, in 10th of a second',
                domain) }
              onChange={ ( value ) =>
              { setAttributes( { scrollDelay: value } ) }
              }
            />
          </>
        }
        <ProLink />
      </PanelBody>
    </Panel>
  )
}