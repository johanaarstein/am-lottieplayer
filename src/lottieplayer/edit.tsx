import { useEffect, useState } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';

import LottieControls from '@components/LottieControls';
import Placeholder from '@components/Placeholder';

import { isTemporaryMedia } from '@functions';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

import './editor.scss';

export default function Edit( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const { id, src } = attributes,
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
		isUploadingMedia = isTemporaryMedia( id as string, src as string );

	useEffect( () => {
		setIsPlaceholder( ! src || src === '' );
	}, [ src ] );
	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			{ isUploadingMedia && <Spinner /> }
			<div { ...useBlockProps() }>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
					isPlaceholder={ isPlaceholder }
					clientId={ clientId }
					isSelected={ isSelected }
					context={ context }
					className={ className }
				/>
			</div>
		</>
	);
}
