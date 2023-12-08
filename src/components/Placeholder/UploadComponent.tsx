import { useState } from '@wordpress/element';
import { BlockIcon, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import Lottie from '@assets/Lottie';

import type { UploadProps } from '@types';

export default function UploadComponent( {
	children,
	onSelectMedia,
	onError,
}: UploadProps ) {
	const [ hasDropped, setHasDropped ] = useState( false );
	return (
		<MediaPlaceholder
			icon={ <BlockIcon icon={ Lottie } /> }
			labels={ {
				title: __( 'AM Lottie Animation', 'am-lottieplayer' ),
				instructions: ! hasDropped
					? __(
							'Upload Lottie animations to WordPress and add them in Gutenberg.',
							'am-lottieplayer'
					  )
					: __( 'Dropped!', 'am-lottieplayer' ),
			} }
			onHTMLDrop={ () => setHasDropped( true ) }
			onSelect={ onSelectMedia }
			accept={ '.lottie, .json' }
			allowedTypes={ [ 'application/json', 'application/zip' ] }
			onError={ onError }
		>
			{ children }
		</MediaPlaceholder>
	);
}
