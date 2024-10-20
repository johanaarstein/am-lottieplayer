import type { PlayerComponentProps } from '@/types';
import type { BlockSaveProps } from '@wordpress/blocks';
import type { AnimationSegment } from 'lottie-web';

import { useBlockProps } from '@wordpress/block-editor';

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
				margin: '0 auto',
				width:
					! attributes.width || attributes.width === 0
						? 'auto'
						: attributes.width,
			} }
		>
			<dotlottie-player
				autoplay={
					attributes.autoplay && ! attributes.scrollEvent ? '' : null
				}
				class={ `lottie-element${
					attributes.selector?.id ? ' has-selector' : ''
				}` }
				controls={ attributes.controls ? '' : null }
				data-click={ attributes.clickEvent }
				data-delay={ attributes.scrollDelay }
				data-direction={ attributes.direction }
				data-mouseout={ attributes.mouseout }
				data-mouseover={ attributes.hover }
				data-once={ attributes.once }
				data-scroll={ attributes.scrollEvent }
				data-selector={ dataSelector }
				description={ attributes.alt }
				direction={ attributes.direction }
				intermission={ attributes.intermission }
				loop={ attributes.loop ? '' : null }
				mode={ attributes.mode }
				multiAnimationSettings={ [] }
				objectfit={ attributes.objectFit }
				segment={ playSegment as unknown as AnimationSegment }
				speed={ attributes.speed }
				src={ attributes.src || '' }
				subframe={ attributes.subframe ? '' : null }
			/>
		</figure>
	);
}
