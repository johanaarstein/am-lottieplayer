import { useEffect, useRef, useState } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';

import LottieControls from '@components/LottieControls';
import Placeholder from '@components/Placeholder';

import { isTemporaryMedia } from '@utils';

import type { BlockEditProps } from 'wordpress__blocks';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';
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
	const animationItem = useRef< DotLottiePlayer >( null ),
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
		isUploadingMedia = isTemporaryMedia( attributes.id, attributes.src );

	useEffect( () => {
		setIsPlaceholder( ! attributes.src || attributes.src === '' );
	}, [ attributes.src ] );
	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
				refObject={ animationItem }
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
					refObject={ animationItem }
				/>
			</div>
		</>
	);
}
