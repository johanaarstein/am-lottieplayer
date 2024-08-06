import { useBlockProps } from '@wordpress/block-editor';

import type { BlockSaveProps } from 'wordpress__blocks';
import type { AnimationSegment } from 'lottie-web';
import type { PlayerComponentProps } from '@types';

export default function save( {
	attributes,
}: BlockSaveProps< PlayerComponentProps > ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		clickEvent,
		direction,
		height,
		hover,
		id,
		loop,
		mode,
		mouseout,
		objectFit,
		once,
		scrollEvent,
		scrollDelay,
		segment,
		selector,
		speed,
		src,
		subframe,
		width,
	} = attributes;

	const dataSelector = JSON.stringify( selector ),
		playSegment =
			! segment || ! segment?.[ 1 ]
				? undefined
				: JSON.stringify( [ segment[ 0 ], segment[ 1 ] ] );

	return (
		<figure
			id={ id }
			{ ...useBlockProps.save( {
				className: `align${ align ?? 'none' }`,
			} ) }
			style={ {
				backgroundColor: background,
				height: ! height || height === 0 ? 'auto' : height,
				width: ! width || width === 0 ? 'auto' : width,
				margin: '0 auto',
			} }
		>
			<dotlottie-player
				class={ `lottie-element${
					selector?.id ? ' has-selector' : ''
				}` }
				autoplay={ autoplay && ! scrollEvent ? '' : null }
				controls={ controls ? '' : null }
				description={ alt }
				direction={ direction }
				data-direction={ direction }
				data-mouseover={ hover }
				data-mouseout={ mouseout }
				data-click={ clickEvent }
				data-scroll={ scrollEvent }
				data-delay={ scrollDelay }
				data-selector={ dataSelector }
				data-once={ once }
				loop={ loop ? '' : null }
				mode={ mode }
				objectfit={ objectFit }
				segment={ playSegment as unknown as AnimationSegment }
				src={ src as string }
				speed={ speed }
				subframe={ subframe ? '' : null }
			/>
		</figure>
	);
}
