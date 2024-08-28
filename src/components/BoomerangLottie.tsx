import { useCallback, useEffect, useRef } from '@wordpress/element';

import { isTouch } from '@utils';

import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';

export default function BoomerangLottie( {
	autoplay,
	src,
	speed = 1,
	subframe,
	className = '',
}: Partial< DotLottiePlayer > ) {
	const boomerang = useRef< DotLottiePlayer >( null ),
		mouseOut = () => {
			if ( isTouch() ) {
				return;
			}
			boomerang.current?.setDirection( -1 );
			void boomerang.current?.play();
		},
		mouseOver = () => {
			if ( isTouch() ) {
				return;
			}
			boomerang.current?.setDirection( 1 );
			void boomerang.current?.play();
		},
		touchScroll = useCallback( () => {
			if ( ! isTouch() || ! boomerang.current ) {
				return;
			}
			if ( boomerang.current.getBoundingClientRect().top < 150 ) {
				boomerang.current.setDirection( 1 );
				void boomerang.current.play();
			} else {
				boomerang.current.setDirection( -1 );
				void boomerang.current.play();
			}
		}, [] );

	useEffect( () => {
		addEventListener( 'scroll', touchScroll, {
			passive: true,
			capture: true,
		} );

		if ( boomerang.current ) {
			boomerang.current.onmouseover = mouseOver;
			boomerang.current.onmouseout = mouseOut;
		}

		return () => {
			removeEventListener( 'scroll', touchScroll, true );
		};
	}, [ touchScroll ] );

	return (
		<dotlottie-player
			autoplay={ autoplay }
			class={ className }
			src={ src ?? '' }
			speed={ speed }
			subframe={ subframe }
			ref={ boomerang }
		/>
	);
}
