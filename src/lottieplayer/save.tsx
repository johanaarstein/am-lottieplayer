import { useBlockProps } from '@wordpress/block-editor';

import type { BlockSaveProps } from '@wordpress/blocks';
import type { AnimationSegment } from 'lottie-web';
import type { PlayerComponentProps } from '@types';

export default function save( {
	attributes,
}: BlockSaveProps< PlayerComponentProps > ) {
	const dataSelector = JSON.stringify( attributes.selector ),
		playSegment =
			! attributes.segment || ! attributes.segment?.[ 1 ]
				? undefined
				: JSON.stringify( [
						attributes.segment[ 0 ],
						attributes.segment[ 1 ],
				  ] );

	return (
		<figure
			id={ attributes.id }
			{ ...useBlockProps.save( {
				className: `align${ attributes.align ?? 'none' }`,
			} ) }
			style={ {
				backgroundColor: attributes.background,
				height:
					! attributes.height || attributes.height === 0
						? 'auto'
						: attributes.height,
				width:
					! attributes.width || attributes.width === 0
						? 'auto'
						: attributes.width,
				margin: '0 auto',
			} }
		>
			<dotlottie-player
				class={ `lottie-element${
					attributes.selector?.id ? ' has-selector' : ''
				}` }
				autoplay={
					attributes.autoplay && ! attributes.scrollEvent ? '' : null
				}
				controls={ attributes.controls ? '' : null }
				description={ attributes.alt }
				direction={ attributes.direction }
				data-direction={ attributes.direction }
				data-mouseover={ attributes.hover }
				data-mouseout={ attributes.mouseout }
				data-click={ attributes.clickEvent }
				data-scroll={ attributes.scrollEvent }
				data-delay={ attributes.scrollDelay }
				data-selector={ dataSelector }
				data-once={ attributes.once }
				loop={ attributes.loop ? '' : null }
				mode={ attributes.mode }
				multiAnimationSettings={ [] }
				objectfit={ attributes.objectFit }
				segment={ playSegment as unknown as AnimationSegment }
				src={ attributes.src as string }
				speed={ attributes.speed }
				subframe={ attributes.subframe ? '' : null }
			/>
		</figure>
	);
}
