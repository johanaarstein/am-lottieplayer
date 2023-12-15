import { useEffect, useState } from '@wordpress/element';
import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

export default function Placeholder( {
	attributes,
	clientId,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const ErrorNotice = ( message: string ) => (
			<Notice status="error">{ message }</Notice>
		),
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
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

	return (
		<>
			{ isPlaceholder ? (
				<UploadComponent
					onSelectMedia={ onSelectMedia }
					onError={ onUploadError }
					children={ undefined }
				/>
			) : (
				<PlayerComponent
					attributes={ attributes }
					clientId={ clientId }
				/>
			) }
		</>
	);
}
