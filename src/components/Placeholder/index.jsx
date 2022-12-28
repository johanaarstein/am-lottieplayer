import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

export default function Placeholder( {
	attributes,
	setAttributes,
	isPlaceholder,
} ) {
	const ErrorNotice = ( message ) => (
			<Notice status="error">{ message }</Notice>
		),
		onUploadError = ( message ) => {
			ErrorNotice( message );
		},
		onSelectMedia = ( { id, url, alt } ) => {
			if ( ! url ) {
				setAttributes( { src: undefined, id: null } );
				return;
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
				<PlayerComponent attributes={ attributes } />
			) }
		</>
	);
}
