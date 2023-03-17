import { useCallback, useEffect, useRef } from '@wordpress/element';

import type { DotLottiePlayer, PlayerComponentProps } from '../../types';

export default function PlayerComponent( { attributes } ) {
	const {
			align,
			alt,
			autoplay,
			background,
			controls,
			direction,
			height,
			loop,
			mode,
			objectFit,
			renderer,
			speed,
			src,
			width,
		}: PlayerComponentProps = attributes,
		player = useRef< DotLottiePlayer >( null ),
		initialRender = useRef( true ),
		reloadPlayer = useCallback( () => {
			if ( ! player.current ) return;
			if ( player.current.reload ) player.current.reload();
			setTimeout( () => {
				const canvas =
					player.current?.shadowRoot?.querySelector( 'canvas' );
				// eslint-disable-next-line no-unused-expressions
				renderer === 'svg' && canvas?.remove();
			}, 100 );
		}, [ renderer ] ),
		parseWidth = useCallback(
			( num: number ) => {
				if ( align === 'wide' || align === 'full' ) return '100%';
				if ( num && typeof num === 'number' ) return `${ num }px`;
				return null;
			},
			[ align ]
		);

	useEffect( () => {
		if ( ! initialRender.current ) {
			reloadPlayer();
		}
		initialRender.current = false;
	}, [ objectFit, reloadPlayer, renderer, speed ] );

	useEffect( () => {
		if (
			player.current &&
			loop &&
			autoplay &&
			player.current.currentState !== 'playing' &&
			player.current.play
		) {
			player.current.play();
		}
	}, [ autoplay, loop ] );

	return (
		<dotlottie-player
			class="lottie-element"
			autoplay={ autoplay ? '' : null }
			controls={ controls ? '' : null }
			description={ alt }
			direction={ direction }
			loop={ loop ? '' : null }
			mode={ mode }
			objectfit={ objectFit }
			ref={ player }
			renderer={ renderer }
			speed={ speed }
			src={ src as string }
			style={ {
				width: typeof width === 'number' ? parseWidth( width ) : null,
				height:
					height && typeof height === 'number'
						? `${ height }px`
						: null,
				backgroundColor: background,
				margin: '0 auto',
			} }
		/>
	);
}
