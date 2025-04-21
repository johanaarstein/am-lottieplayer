import type { PlayerComponentProps } from '@/types';

import Lottie from '@/assets/Lottie';
import { isValidUrl } from '@/utils';
import {
	BlockIcon,
	MediaPlaceholder,
	MediaUploadCheck,
	URLInput,
} from '@wordpress/block-editor';
import { Notice } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

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
		onSelectMedia = (props: {
			id: number;
			url: string;
			alt?: string;
		} ) => {
			if ( ! props?.url ) {
				return setAttributes( { id: undefined, src: undefined } );
			}
			setAttributes( {
				alt: props.alt,
				id: props.id?.toString(),
				src: props.url,
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
								'Add Lottie animations from your Media Library to your WordPress post.',
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
