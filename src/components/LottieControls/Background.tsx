import type { BlockEditProps } from '@wordpress/blocks'

import {
  ColorPicker, Panel, PanelBody
} from '@wordpress/components'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import { domain } from '@/utils/constants'

export default function Background({
  attributes,
  setAttributes,
}: BlockEditProps<PlayerComponentProps>) {
  const { background } = attributes

  return (
    <Panel>
      <PanelBody
        initialOpen
        className="am-lottieplayer-settings"
        title={__('Background Color', domain)}
      >
        <ColorPicker
          color={background}
          onChange={(color) => { setAttributes({ background: color }) }
          }
        />
      </PanelBody>
    </Panel>
  )
}
