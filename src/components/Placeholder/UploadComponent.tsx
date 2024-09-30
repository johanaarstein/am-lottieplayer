import { useEffect, useState } from '@wordpress/element';
import {
	BlockIcon,
	MediaPlaceholder,
	MediaUploadCheck,
	URLInput,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { Notice } from '@wordpress/components';

import Lottie from '@assets/Lottie';
import { isValidUrl } from '@utils';

import type { PlayerComponentProps } from '@types';

export default function UploadComponent( {
	attributes,
	setAttributes,
}: {
	readonly attributes: PlayerComponentProps;
	readonly setAttributes: ( attrs: Partial< PlayerComponentProps > ) => void;
} ) {
	const [ state, setState ] = useState( {
			externalURL: attributes.src || '',
			hasDropped: false,
		} ),
		onSelectMedia = ( {
			alt,
			id,
			url,
		}: {
			id: number;
			url: string;
			alt: string;
		} ) => {
			if ( ! url ) {
				return setAttributes( { id: undefined, src: undefined } );
			}
			setAttributes( {
				alt,
				id: id?.toString(),
				src: url,
			} );
		},
		ErrorNotice = ( message: string ) => (
			<Notice className="am-lottieplayer-notice" status="error">
				{ message }
			</Notice>
		),
		onError = ( message: string ) => {
			ErrorNotice( message );
		};

	useEffect( () => {
		if (
			isValidUrl( state.externalURL ) &&
			( state.externalURL.endsWith( '.lottie' ) ||
				state.externalURL.endsWith( '.json' ) )
		) {
			setAttributes( {
				src: state.externalURL,
			} );
		}
	}, [ state.externalURL, setAttributes ] );

	return (
		<MediaUploadCheck>
			<MediaPlaceholder
				accept={ '.lottie, .json' }
				allowedTypes={ [ 'application/json', 'application/zip' ] }
				icon={ <BlockIcon icon={ Lottie } /> }
				labels={ {
					instructions: ! state.hasDropped
						? __(
								'Upload Lottie animations to WordPress and add them in Gutenberg.',
								'am-lottieplayer'
						  )
						: __( 'Dropped!', 'am-lottieplayer' ),
					title: __( 'AM Lottie Animation', 'am-lottieplayer' ),
				} }
				onError={ onError }
				onHTMLDrop={ () =>
					setState( ( prev ) => ( { ...prev, hasDropped: true } ) )
				}
				onSelect={ onSelectMedia }
			>
				{
					(
						<URLInput
							onChange={ ( externalURL ) =>
								setState( ( prev ) => ( {
									...prev,
									externalURL,
								} ) )
							}
							value={ state.externalURL }
						/>
					 ) as unknown as undefined
				}
			</MediaPlaceholder>
		</MediaUploadCheck>
	);
}
