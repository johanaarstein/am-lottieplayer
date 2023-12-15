import { useCallback, useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

import { usePlayerContext } from '@context/PlayerWrapper';

import type { AnimationSegment } from 'lottie-web';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';
import type { PlayerComponentProps } from '@types';

export default function PlayerComponent( {
	attributes,
	clientId,
}: {
	attributes: PlayerComponentProps;
	clientId: string;
} ) {
	const {
			animationContext: { player },
			setAnimationContext,
		} = usePlayerContext(),
		{ segment } = attributes,
		{ getBlockIndex }: { getBlockIndex: ( str: string ) => number } =
			useSelect( ( select ) => select( 'core/block-editor' ), [] ),
		blockIndex = getBlockIndex( clientId ),
		initialRender = useRef( true ),
		playerRef = useRef< DotLottiePlayer >( null ),
		playSegment =
			! segment || ! segment?.[ 1 ]
				? undefined
				: JSON.stringify( [ segment[ 0 ], segment[ 1 ] ] ),
		reloadPlayer = useCallback( () => {
			if ( ! player ) return;
			void player.reload();
			setTimeout( () => {
				const canvas = player?.shadowRoot?.querySelector( 'canvas' );
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
		if ( playerRef.current ) {
			setAnimationContext( ( prev ) => ( {
				...prev,
				player: playerRef.current,
			} ) );
		}
	}, [ setAnimationContext ] );

	useEffect( () => {
		if ( player ) {
			player.addEventListener( 'ready', () => {
				setAnimationContext( ( prev ) => ( {
					...prev,
					animations: player.getManifest()?.animations ?? [],
				} ) );
			} );
		}
	}, [ player, setAnimationContext ] );

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
			ref={ playerRef }
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
