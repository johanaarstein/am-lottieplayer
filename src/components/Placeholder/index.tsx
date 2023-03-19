import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import type { PlaceholderProps } from '../../types';

export default function Placeholder( {
	attributes,
	clientId,
	isPlaceholder,
	setAttributes,
}: PlaceholderProps ) {
	const ErrorNotice = ( message: string ) => (
			<Notice status="error">{ message }</Notice>
		),
		onUploadError = ( message: string ) => {
			ErrorNotice( message );
		},
		onSelectMedia = ( { id, url, alt } ) => {
			if ( ! url ) {
				return setAttributes( { src: undefined, id: undefined } );
			}
			setAttributes( {
				src: url,
				id,
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
				/>
			) }
		</>
	);
}
