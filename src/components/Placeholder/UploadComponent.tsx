import { BlockIcon, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import { Lottie } from '../../assets/icons';

import type { UploadProps } from '../../types';

export default function UploadComponent( {
	children,
	onSelectMedia,
	onError,
}: UploadProps ) {
	return (
		<MediaPlaceholder
			icon={ <BlockIcon icon={ Lottie } /> }
			labels={ {
				title: __( 'AM Lottie Animation', 'am-lottieplayer' ),
				instructions: __(
					'Upload Lottie animations to WordPress and add them in Gutenberg.',
					'am-lottieplayer'
				),
			} }
			onSelect={ onSelectMedia }
			accept={ '.lottie, .json' }
			allowedTypes={ [ 'application/json', 'application/zip' ] }
			onError={ onError }
		>
			{ children }
		</MediaPlaceholder>
	);
}
