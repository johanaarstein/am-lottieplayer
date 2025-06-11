/* eslint-disable @typescript-eslint/naming-convention */
import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light'
import type { BlockEditProps } from '@wordpress/blocks'

import {
  Panel,
  PanelBody,
  PanelRow,
  SelectControl,
} from '@wordpress/components'
import { useCallback } from '@wordpress/element'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import NumberInput from '@/components/form/NumberInput'
import SwitchLabel from '@/components/form/SwitchLabel'
import { Align } from '@/enums'

const domain = 'am-lottieplayer'

export default function Dimensions ( {
  attributes,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const {
      align,
      fullscreen,
      height,
      objectFit = 'contain',
      width,
    } = attributes,

    parseWidth = useCallback(( num: number | string ) => {
      if ( align === Align.Full || align === Align.Wide ) {
        return '100%'
      }

      return ! num || num === '0' ? undefined : num
    },
    [ align ])

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={ __( 'Dimensions', domain ) }
      >
        { ( ! fullscreen || align !== Align.Full ) &&
          <PanelRow className="lottie-dimensions">
            <NumberInput
              id="am-lottieplayer-width-settings"
              title={ __( 'Width', domain ) }
              value={ parseWidth( width as number ) }
              disabled={
                align === Align.Full || align === Align.Wide
              }
              placeholder={
                align === Align.Full || align === Align.Wide
                  ? '100%'
                  : 'auto'
              }
              onChange={ ( val ) =>
              { setAttributes( { width: val ?? null } ) }
              }
            />
            <NumberInput
              disabled={ fullscreen }
              id="am-lottieplayer-height-settings"
              placeholder={ 'auto' }
              title={ __( 'Height', domain ) }
              value={
                ! height || height.toString() === '0'
                  ? undefined
                  : height
              }
              onChange={ ( val ) =>
              { setAttributes( { height: val } ) }
              }
            />
          </PanelRow>
        }
        { ( align === Align.Full || align === Align.Wide ) &&
          <SwitchLabel
            id="am-lottieplayer-fullscreen-settings"
            title={ __( 'Fill screen', domain ) }
            value={ fullscreen }
            onChange={ ( value ) =>
            { setAttributes( { fullscreen: value } ) }
            }
          />
        }
        <SelectControl
          label={ __( 'Object fit' ) }
          value={ objectFit as 'contain' | 'cover' | 'fill' | 'none' }
          options={ [
            {
              label: __( 'Contain', domain ),
              value: 'contain',
            },
            {
              label: __( 'Cover', domain ),
              value: 'cover',
            },
            {
              label: __( 'Fill', domain ),
              value: 'fill',
            },
            {
              label: __( 'None', domain ),
              value: 'none',
            },
          ] }
          onChange={ ( val ) => {
            setAttributes( { objectFit: val as DotLottiePlayer[ 'objectfit' ] } )
          } }
        />
      </PanelBody>
    </Panel>
  )
}
