import React from 'react';
import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import { attributesFromMedia } from '../../functions';

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
		onSelectMedia = () => attributesFromMedia( setAttributes );

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
