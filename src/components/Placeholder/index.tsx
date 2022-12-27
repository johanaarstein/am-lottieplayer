import React, { Dispatch, SetStateAction } from 'react';
import { Notice } from '@wordpress/components';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import { attributesFromMedia } from '../../functions';

import { LottiePlayer } from '../../global.d';

type PlaceholderProps = {
	attributes: LottiePlayer;
	setAttributes: Dispatch< SetStateAction< Partial< LottiePlayer > > >;
	isPlaceholder: boolean;
};

export default function Placeholder( {
	attributes,
	setAttributes,
	isPlaceholder,
}: PlaceholderProps ) {
	const ErrorNotice = ( message: string ) => (
			<Notice status="error">{ message }</Notice>
		),
		onUploadError = ( message: string ) => {
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
