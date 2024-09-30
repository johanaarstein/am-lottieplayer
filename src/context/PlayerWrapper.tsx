import { createContext, useContext, useState } from '@wordpress/element';

import type { Dispatch, SetStateAction } from 'react';
import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light';

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
		animationContext: {
			animations: [],
			player: null,
		},
		setAnimationContext: ( value: SetStateAction< AnimationContext > ) =>
			value,
	} ),
	usePlayerContext = () => useContext( PlayerContext );

export default function PlayerWrapper( { children } ) {
	const [ animationContext, setAnimationContext ] =
		useState< AnimationContext >( {
			animations: [],
			player: null,
		} );
	return (
		<PlayerContext.Provider
			value={ { animationContext, setAnimationContext } }
		>
			{ children }
		</PlayerContext.Provider>
	);
}
