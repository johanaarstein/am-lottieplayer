import { useEffect, useState } from '@wordpress/element';

import UploadComponent from './UploadComponent';
import PlayerComponent from './PlayerComponent';

import type { BlockEditProps } from '@wordpress/blocks';
import type { PlayerComponentProps } from '@types';

export default function Placeholder( {
	attributes,
	clientId,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const [ state, setState ] = useState( {
		isPlaceholder: true,
	} );

	useEffect( () => {
		setState( ( prev ) => ( {
			...prev,
			isPlaceholder: ! attributes.src || attributes.src === '',
		} ) );
	}, [ attributes.src ] );

	return (
		<>
			{ state.isPlaceholder ? (
				<UploadComponent
					attributes={ attributes }
					setAttributes={ setAttributes }
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
