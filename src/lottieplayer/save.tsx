import React from 'react';
import { useBlockProps } from '@wordpress/block-editor';

import { aspectRatio, isTouch } from '../functions';

import { LottiePlayer } from '../global.d';

export default function save( { attributes } ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		direction,
		height,
		hover,
		id,
		loop,
		mode,
		mouseout,
		objectFit,
		renderer,
		speed,
		src,
		width,
	} = attributes as LottiePlayer;

	const mouseOver = ( { target } ) => {
			if ( isTouch() || ! hover ) return;
			target.setDirection( direction );
			target.play();
		},
		mouseOut = ( { target } ) => {
			if ( isTouch() || ! hover ) return;
			switch ( mouseout ) {
				case 'void':
					break;
				case 'stop':
					target?.stop();
					break;
				case 'pause':
					target?.pause();
					break;
				case 'reverse':
					target?.setDirection( direction * -1 );
					target?.play();
					break;
				default:
					target?.stop();
			}
		};

	return (
		<figure
			id={ id }
			{ ...useBlockProps.save( {
				className: `align${ align }`,
			} ) }
			style={ {
				backgroundColor: background,
				height: ! height || height === 0 ? 'auto' : height,
				width: ! width || width === 0 ? 'auto' : width,
			} }
		>
			<dotlottie-player
				autoplay={ autoplay }
				controls={ controls }
				description={ alt }
				direction={ direction }
				loop={ loop }
				onmouseover={ mouseOver }
				onmouseout={ mouseOut }
				mode={ mode }
				preserveAspectRatio={ aspectRatio( objectFit as string ) }
				renderer={ renderer }
				src={ src }
				speed={ speed }
			/>
		</figure>
	);
}
