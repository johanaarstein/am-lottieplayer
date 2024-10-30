import type { PlayerComponentProps } from '@/types';
import type { BlockSaveProps } from '@wordpress/blocks';

import { useBlockProps } from '@wordpress/block-editor';

export default function save( {
	attributes,
}: BlockSaveProps< PlayerComponentProps > ) {
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
				description={ attributes.alt }
				direction={ attributes.direction }
				intermission={ attributes.intermission }
				loop={ attributes.loop ? '' : null }
				mode={ attributes.mode }
				objectfit={ attributes.objectFit }
				simple={ attributes.simple }
				speed={ attributes.speed }
				src={ attributes.src || '' }
				subframe={ attributes.subframe ? '' : null }
			/>
		</figure>
	);
}
