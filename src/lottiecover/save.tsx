import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { Align } from '@utils';

import type { BlockSaveProps } from '@wordpress/blocks';
import type { AnimationSegment } from 'lottie-web';
import type { PlayerComponentProps } from '@types';

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
				data-delay={ attributes.scrollDelay }
				data-scroll={ attributes.scrollEvent }
				data-selector={ dataSelector }
				data-once={ attributes.once }
				loop={ attributes.loop ? '' : null }
				mode={ attributes.mode }
				multiAnimationSettings={ [] }
				objectfit={ attributes.objectFit }
				segment={ playSegment as unknown as AnimationSegment }
				speed={ attributes.speed }
				src={ attributes.src as string }
				style={ {
					width: parseWidth( attributes.width as number ),
					height:
						attributes.height &&
						typeof attributes.height === 'number'
							? `${ attributes.height }px`
							: undefined,
					backgroundColor: attributes.background,
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
