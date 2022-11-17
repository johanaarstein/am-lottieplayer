import { useDispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import { attributesFromMedia } from '../../functions';

export default function Placeholder( {
	attributes = {},
	setAttributes = () => {},
	isPlaceholder = false,
} = {} ) {
	const { createErrorNotice } = useDispatch( noticesStore ),
		onUploadError = ( message ) => {
			createErrorNotice( message, { type: 'snackbar' } );
		},
		onSelectMedia = attributesFromMedia( setAttributes );

	return (
		<>
			{ isPlaceholder ? (
				<UploadComponent
					onSelectMedia={ onSelectMedia }
					onError={ onUploadError }
					disableMediaButtons={ ! isPlaceholder }
				/>
			) : (
				<PlayerComponent attributes={ attributes } />
			) }
		</>
	);
}
