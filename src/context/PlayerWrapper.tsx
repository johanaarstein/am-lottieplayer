import { createContext, useContext, useState } from '@wordpress/element';

import type { Dispatch, SetStateAction } from 'react';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';

type Animations = ReturnType<
	DotLottiePlayer[ 'getManifest' ]
>[ 'animations' ];

interface AnimationContext {
	player: null | DotLottiePlayer;
	animations: Animations;
}

export const PlayerContext = createContext< {
		setAnimationContext: Dispatch< SetStateAction< AnimationContext > >;
		animationContext: AnimationContext;
	} >( {
		setAnimationContext: ( value: SetStateAction< AnimationContext > ) =>
			value,
		animationContext: {
			player: null,
			animations: [],
		},
	} ),
	usePlayerContext = () => useContext( PlayerContext );

export default function PlayerWrapper( { children } ) {
	const [ animationContext, setAnimationContext ] =
		useState< AnimationContext >( {
			player: null,
			animations: [],
		} );
	return (
		<PlayerContext.Provider
			value={ { animationContext, setAnimationContext } }
		>
			{ children }
		</PlayerContext.Provider>
	);
}
