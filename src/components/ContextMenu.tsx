import { BlockControls } from '@wordpress/block-editor'
import { __ } from '@wordpress/i18n'

import type { LottieBlockAttributes } from '@/types'

import MediaReplace from '@/components/MediaReplace'

export default function ContextMenu( {
  attributes,
  setAttributes,
}: LottieBlockAttributes ) {
  return (
    <BlockControls>
      <MediaReplace
        attributes={ attributes }
        setAttributes={ setAttributes }
      />
    </BlockControls>
  )
}
