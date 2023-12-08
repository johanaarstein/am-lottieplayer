import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import type { PlaceholderProps } from '@types';

export default function Placeholder( {
	attributes,
	clientId,
	isPlaceholder,
	setAttributes,
	refObject,
}: PlaceholderProps ) {
	const ErrorNotice = ( message: string ) => (
			<Notice status="error">{ message }</Notice>
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
					refObject={ refObject }
				/>
			) }
		</>
	);
}
