import { useBlockProps } from '@wordpress/block-editor';
import '@johanaarstein/dotlottie-player';

import { aspectRatio } from './functions';

export default function save( { attributes } ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		direction,
		id,
		loop,
		mode,
		objectFit,
		src,
	} = attributes;

	return (
		<figure
			id={ id }
			className={ align }
			{ ...useBlockProps.save() }
			style={ { backgroundColor: background } }
		>
			<dotlottie-player
				autoplay={ autoplay }
				controls={ controls }
				description={ alt }
				direction={ direction }
				loop={ loop }
				mode={ mode }
				preserveAspectRatio={ aspectRatio( objectFit ) }
				src={ src }
			/>
		</figure>
	);
}
