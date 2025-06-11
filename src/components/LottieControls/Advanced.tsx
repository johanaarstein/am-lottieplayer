import type { BlockEditProps } from '@wordpress/blocks'

import { InspectorAdvancedControls } from '@wordpress/block-editor'
import { SelectControl, TextareaControl } from '@wordpress/components'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import ProFeature from '@/assets/ProFeature'
import ProLink from '@/components/ProLink'

export default function Advanced( {
  attributes,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const { alt } = attributes

  return (
    <InspectorAdvancedControls>
      <SelectControl
        disabled
        help={ <ProLink /> }
        value="svg"
        label={
          <>
            <span
              className="pro-feature"
              style={ { marginRight: '1em' } }
            >
              { __( 'Renderer' ) }
            </span>
            <ProFeature />
          </>
        }
        options={ [
          {
            label: 'SVG',
            value: 'svg'
          }, {
            label: 'Canvas',
            value: 'canvas'
          },
        ] }
        onChange={ () =>
        { console.warn('This feature is only available in the premium version') }
        }
      />
      <TextareaControl
        label={ __( 'Description', 'am-lottieplayer' ) }
        value={ alt as string }
        help={ __('Describe the animation. This is helpful for screen readers and search engines.',
          'am-lottieplayer') }
        onChange={ ( value ) => { setAttributes( { alt: value } ) } }
      />
    </InspectorAdvancedControls>
  )
}
