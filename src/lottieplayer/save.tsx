import { useBlockProps } from '@wordpress/block-editor';

import type { BlockSaveProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '../types';

export default function save( { attributes }: BlockSaveProps< object > ) {
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
		renderer,
		speed,
		src,
		width,
	}: PlayerComponentProps = attributes;

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
				data-click={ clickEvent }
				loop={ loop }
				mode={ mode }
				objectfit={ objectFit }
				renderer={ renderer }
				src={ src }
				speed={ speed }
			/>
		</figure>
	);
}
