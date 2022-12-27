import React from 'react';
import { useCallback, useEffect, useRef } from '@wordpress/element';
import { DotLottiePlayer } from '@johanaarstein/dotlottie-player';

import { aspectRatio } from '../../functions';

import { LottiePlayer } from '../../global.d';

export default function PlayerComponent( { attributes = {} } = {} ) {
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
		} = attributes as LottiePlayer,
		player = useRef< DotLottiePlayer | null >( null ),
		initialRender = useRef( true ),
		reloadPlayer = useCallback( () => {
			if ( ! player.current ) return;
			player.current.reload();
			setTimeout( () => {
				const canvas =
					player.current?.shadowRoot?.querySelector( 'canvas' );
				// eslint-disable-next-line no-unused-expressions
				renderer === 'svg' && canvas && canvas.remove();
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
			player.current.currentState !== 'playing'
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
			preserveAspectRatio={ aspectRatio( objectFit as string ) }
			ref={ player }
			renderer={ renderer }
			speed={ speed }
			src={ src }
			style={ {
				width: parseWidth( width as number ),
				height:
					height && typeof height === 'number'
						? `${ height }px`
						: null,
				backgroundColor: background as string,
			} }
		/>
	);
}
