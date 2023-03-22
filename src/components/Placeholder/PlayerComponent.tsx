import { useCallback, useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

import type { DotLottiePlayer } from '@johanaarstein/dotlottie-player';
import type { PlayerComponentProps } from '../../types';

export default function PlayerComponent( {
	attributes,
	clientId,
}: {
	attributes: PlayerComponentProps;
	clientId: string;
} ) {
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
		} = attributes,
		{ getBlockIndex } = useSelect(
			( select ) => select( 'core/block-editor' ),
			[]
		),
		blockIndex = getBlockIndex( clientId ),
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
		parseSize = ( num?: number ): string | null => {
			if ( num && typeof num === 'number' ) return `${ num }px`;
			return null;
		},
		parseWidth = ( num?: number ): string | null => {
			if ( align === 'wide' || align === 'full' ) return '100%';
			return parseSize( num );
		};

	useEffect( () => {
		if ( ! initialRender.current ) {
			reloadPlayer();
		}
		initialRender.current = false;
	}, [
		autoplay,
		blockIndex,
		direction,
		loop,
		mode,
		objectFit,
		reloadPlayer,
		renderer,
		speed,
	] );

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
				width: parseWidth( width ),
				height: parseSize( height ),
				backgroundColor: background,
				margin: '0 auto',
			} }
		/>
	);
}