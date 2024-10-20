import type { PlayerComponentProps } from '@/types';
import type { BlockSaveProps } from '@wordpress/blocks';
import type { AnimationSegment } from 'lottie-web';

import { Align } from '@/enums';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export default function save( {
	attributes,
}: BlockSaveProps< PlayerComponentProps > ) {
	const heightWithUnit =
			attributes.height && attributes.heightUnit
				? `${ attributes.height }${ attributes.heightUnit }`
				: attributes.height,
		style = {
			minHeight: attributes.fullscreen
				? '100vh'
				: heightWithUnit || undefined,
		},
		dataSelector = JSON.stringify( attributes.selector ),
		playSegment =
			! attributes.segment || ! attributes.segment?.[ 1 ]
				? undefined
				: JSON.stringify( [
						attributes.segment[ 0 ],
						attributes.segment[ 1 ],
				  ] ),
		parseWidth = ( num: number ) => {
			if (
				attributes.align === Align.Wide ||
				attributes.align === Align.Full
			) {
				return '100%';
			}
			if ( num && typeof num === 'number' ) {
				return `${ num }px`;
			}
		};

	return (
		<div { ...useBlockProps.save( { style } ) }>
			<span
				aria-hidden="true"
				className={ `wp-block-gb-lottiecover__background` }
				style={ { backgroundColor: attributes.background } }
			/>
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
				style={ {
					backgroundColor: attributes.background,
					height:
						attributes.height &&
						typeof attributes.height === 'number'
							? `${ attributes.height }px`
							: undefined,
					width: parseWidth( attributes.width as number ),
				} }
				subframe={ attributes.subframe ? '' : null }
			/>
			<div
				{ ...useInnerBlocksProps.save( {
					className: 'wp-block-gb-lottiecover__inner-container',
				} ) }
			/>
		</div>
	);
}
