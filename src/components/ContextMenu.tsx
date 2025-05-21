import { BlockControls } from '@wordpress/block-editor'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import MediaReplace from '@/components/MediaReplace'

export default function ContextMenu( {
  attributes,
  setAttributes,
}: {
  attributes: PlayerComponentProps;
  readonly setAttributes: ( attrs: Partial< PlayerComponentProps > ) => void;
} ) {
  return (
    <BlockControls>
      <MediaReplace
        attributes={ attributes }
        setAttributes={ setAttributes }
      />
    </BlockControls>
  )
}
