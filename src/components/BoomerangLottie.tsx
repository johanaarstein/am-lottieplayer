import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light';

import { isTouch } from '@/utils';
import { useCallback, useEffect, useRef } from '@wordpress/element';

export default function BoomerangLottie( {
	autoplay,
	className = '',
	speed = 1,
	src,
	subframe,
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
			capture: true,
			passive: true,
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
			ref={ boomerang }
			speed={ speed }
			src={ src ?? '' }
			subframe={ subframe }
		/>
	);
}
