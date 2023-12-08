import { useCallback, useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

import type { RefObject } from 'react';
import type { AnimationSegment } from 'lottie-web';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';
import type { PlayerComponentProps } from '@types';

export default function PlayerComponent( {
	attributes,
	clientId,
	refObject: player,
}: {
	attributes: PlayerComponentProps;
	clientId: string;
	refObject: RefObject< DotLottiePlayer >;
} ) {
	const { segment } = attributes,
		{ getBlockIndex }: { getBlockIndex: ( str: string ) => number } =
			useSelect( ( select ) => select( 'core/block-editor' ), [] ),
		blockIndex = getBlockIndex( clientId ),
		initialRender = useRef( true ),
		playSegment =
			! segment || ! segment?.[ 1 ]
				? undefined
				: JSON.stringify( [ segment[ 0 ], segment[ 1 ] ] ),
		reloadPlayer = useCallback( () => {
			if ( ! player.current ) return;
			if ( player.current.reload ) void player.current.reload();
			setTimeout( () => {
				const canvas =
					player.current?.shadowRoot?.querySelector( 'canvas' );
				if ( attributes.renderer === 'svg' ) {
					canvas?.remove();
				}
			}, 100 );
		}, [ player, attributes.renderer ] ),
		parseSize = ( num?: number | null ) => {
			if ( num && typeof num === 'number' ) return `${ num }px`;
		},
		parseWidth = ( num?: number | null ) => {
			if ( attributes.align === 'wide' || attributes.align === 'full' )
				return '100%';
			return parseSize( num );
		};

	useEffect( () => {
		if ( ! initialRender.current ) {
			reloadPlayer();
		}
		initialRender.current = false;
	}, [
		attributes.autoplay,
		blockIndex,
		attributes.direction,
		attributes.loop,
		attributes.mode,
		attributes.objectFit,
		reloadPlayer,
		attributes.renderer,
		segment,
		attributes.speed,
		attributes.subframe,
	] );

	return (
		<dotlottie-player
			id={ clientId }
			class="lottie-element"
			autoplay={ attributes.autoplay ? '' : null }
			controls={ attributes.controls ? '' : null }
			description={ attributes.alt }
			direction={ attributes.direction }
			loop={ attributes.loop ? '' : null }
			mode={ attributes.mode }
			objectfit={ attributes.objectFit }
			ref={ player }
			renderer={ attributes.renderer }
			segment={ playSegment as unknown as AnimationSegment }
			speed={ attributes.speed }
			subframe={ attributes.subframe ? '' : null }
			src={ attributes.src ?? '' }
			style={ {
				width: parseWidth( attributes.width ),
				height: parseSize( attributes.height ),
				backgroundColor: attributes.background,
				margin: '0 auto',
			} }
		/>
	);
}
