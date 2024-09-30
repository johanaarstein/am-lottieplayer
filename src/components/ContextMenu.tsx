import type { PlayerComponentProps } from '@types';

import { BlockControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import MediaReplace from './MediaReplace';

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
	);
}
