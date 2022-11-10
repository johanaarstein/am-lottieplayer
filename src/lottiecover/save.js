import { useBlockProps } from '@wordpress/block-editor';

import { aspectRatio } from '../functions';

export default function save( { attributes } ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		direction,
		height,
		id,
		loop,
		mode,
		objectFit,
		src,
		width,
	} = attributes;

	return (
		<figure
			id={ id }
			{ ...useBlockProps.save( {
				className: `align${ align }`,
			} ) }
			style={ {
				backgroundColor: background,
				height: ! height || height === '0' ? 'auto' : height,
				width: ! width || width === '0' ? 'auto' : width,
			} }
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
