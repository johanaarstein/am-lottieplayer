import type { BlockEditProps } from '@wordpress/blocks'

import { InspectorAdvancedControls } from '@wordpress/block-editor'
import { SelectControl, TextareaControl } from '@wordpress/components'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import ProFeature from '@/assets/ProFeature'
import ProLink from '@/components/ProLink'
import { domain } from '@/utils/constants'

export default function Advanced({
  attributes,
  setAttributes,
}: BlockEditProps<PlayerComponentProps>) {
  const { description } = attributes

  return (
    <InspectorAdvancedControls>
      <SelectControl
        disabled
        help={<ProLink />}
        value="svg"
        label={
          <>
            <span
              className="pro-feature"
              style={{ marginRight: '1em' }}
            >
              {__('Renderer')}
            </span>
            <ProFeature />
          </>
        }
        options={[
          {
            label: 'SVG',
            value: 'svg'
          }, {
            label: 'Canvas',
            value: 'canvas'
          },
        ]}
        onChange={() => { console.warn('This feature is only available in the premium version') }
        }
      />
      <TextareaControl
        label={__('Description', domain)}
        value={description ?? ''}
        help={__('Describe the animation. This is helpful for screen readers and search engines.',
          domain)}
        onChange={(value) => { setAttributes({ description: value }) }}
      />
    </InspectorAdvancedControls>
  )
}
