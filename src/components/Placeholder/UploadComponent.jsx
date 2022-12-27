import React from 'react';
import { BlockIcon, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import { Lottie } from '../../assets/icons';

export default function UploadComponent( {
	children,
	onSelectMedia,
	onError,
} ) {
	return (
		<MediaPlaceholder
			icon={ <BlockIcon icon={ Lottie } /> }
			labels={ {
				title: __( 'AM Lottie Animation' ),
				instructions: __(
					'Upload Lottie animations to WordPress and add them in Gutenberg.'
				),
			} }
			onSelect={ onSelectMedia }
			accept={ '.lottie, .json' }
			allowedTypes={ [
				'application/json',
				'application/zip',
				// 'text/plain',
			] }
			onError={ onError }
		>
			{ children }
		</MediaPlaceholder>
	);
}
