import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const {
			align,
			alt,
			autoplay,
			background,
			controls,
			clickEvent,
			direction,
			height,
			heightUnit,
			hover,
			loop,
			mode,
			mouseout,
			objectFit,
			renderer,
			speed,
			src,
			width,
		} = attributes,
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: heightWithUnit || undefined,
		},
		parseWidth = ( num ) => {
			if ( align === 'wide' || align === 'full' ) return '100%';
			if ( num && typeof num === 'number' ) return `${ num }px`;
			return null;
		};

	return (
		<div { ...useBlockProps.save( { style } ) }>
			<span
				aria-hidden="true"
				className={ `wp-block-gb-lottiecover__background` }
				style={ { backgroundColor: background } }
			/>
			<dotlottie-player
				class="lottie-element"
				autoplay={ autoplay ? '' : null }
				controls={ controls ? '' : null }
				description={ alt }
				direction={ direction }
				data-direction={ direction }
				data-mouseover={ hover }
				data-mouseout={ mouseout }
				data-click={ clickEvent }
				loop={ loop ? '' : null }
				mode={ mode }
				objectfit={ objectFit }
				renderer={ renderer }
				speed={ speed }
				src={ src }
				style={ {
					width: parseWidth( width ),
					height:
						height && typeof height === 'number'
							? `${ height }px`
							: null,
					backgroundColor: background,
				} }
			/>
			<div
				{ ...useInnerBlocksProps.save( {
					className: 'wp-block-gb-lottiecover__inner-container',
				} ) }
			/>
		</div>
	);
}
