import { useBlockProps } from '@wordpress/block-editor';

import { aspectRatio } from '../functions';

export default function save( { attributes } ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		click,
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
	} = attributes;

	// const mouseOver = ( { target } ) => {
	// 		// eslint-disable-next-line no-console
	// 		console.log( 'foo' );
	// 		if ( isTouch() || ! hover ) return;
	// 		target.setDirection( direction );
	// 		target.play();
	// 	},
	// 	mouseOut = ( { target } ) => {
	// 		if ( isTouch() || ! hover ) return;
	// 		switch ( mouseout ) {
	// 			case 'void':
	// 				break;
	// 			case 'stop':
	// 				target?.stop();
	// 				break;
	// 			case 'pause':
	// 				target?.pause();
	// 				break;
	// 			case 'reverse':
	// 				target?.setDirection( direction * -1 );
	// 				target?.play();
	// 				break;
	// 			default:
	// 				target?.stop();
	// 		}
	// 	};

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
				margin: '0 auto',
			} }
		>
			<dotlottie-player
				autoplay={ autoplay }
				controls={ controls }
				description={ alt }
				direction={ direction }
				data-direction={ direction }
				data-mouseover={ hover }
				data-mouseout={ mouseout }
				data-click={ click }
				loop={ loop }
				mode={ mode }
				preserveAspectRatio={ aspectRatio( objectFit ) }
				renderer={ renderer }
				src={ src }
				speed={ speed }
			/>
		</figure>
	);
}
