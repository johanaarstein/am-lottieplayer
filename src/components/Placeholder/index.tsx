import { useEffect, useState } from '@wordpress/element';
import { Notice } from '@wordpress/components';
import { URLInput } from '@wordpress/block-editor';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';
import { isValidUrl } from '@utils';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

export default function Placeholder( {
	attributes,
	clientId,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const [ isPlaceholder, setIsPlaceholder ] = useState( true ),
		[ externalURL, setExternalURL ] = useState( '' ),
		ErrorNotice = ( message: string ) => (
			<Notice className="am-lottieplayer-notice" status="error">
				{ message }
			</Notice>
		),
		onUploadError = ( message: string ) => {
			ErrorNotice( message );
		},
		onSelectMedia = ( {
			id,
			url,
			alt,
		}: {
			id: number;
			url: string;
			alt: string;
		} ) => {
			if ( ! url ) {
				return setAttributes( { src: undefined, id: undefined } );
			}
			setAttributes( {
				src: url,
				id: id?.toString(),
				alt,
			} );
		};

	useEffect( () => {
		setIsPlaceholder( ! attributes.src || attributes.src === '' );
	}, [ attributes.src ] );
	useEffect( () => {
		if (
			isValidUrl( externalURL ) &&
			( externalURL.endsWith( '.lottie' ) ||
				externalURL.endsWith( '.json' ) )
		) {
			setAttributes( {
				src: externalURL,
			} );
		}
	}, [ externalURL, setAttributes ] );

	return (
		<>
			{ isPlaceholder ? (
				<UploadComponent
					onSelectMedia={ onSelectMedia }
					onError={ onUploadError }
				>
					<URLInput
						value={ externalURL }
						onChange={ ( url ) => setExternalURL( url ) }
					/>
				</UploadComponent>
			) : (
				<PlayerComponent
					attributes={ attributes }
					clientId={ clientId }
				/>
			) }
		</>
	);
}
