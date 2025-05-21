import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light'
import type { Dispatch, SetStateAction } from 'react'

import {
  createContext, useContext, useState
} from '@wordpress/element'

type Animations = ReturnType<
  DotLottiePlayer[ 'getManifest' ]
>[ 'animations' ]

interface AnimationContext {
  animations: Animations;
  player: null | DotLottiePlayer;
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
  usePlayerContext = () => useContext( PlayerContext )

export default function PlayerWrapper( { children } ) {
  const [ animationContext, setAnimationContext ] =
		useState< AnimationContext >( {
		  animations: [],
		  player: null,
		} )

  return (
    <PlayerContext.Provider
      value={ {
        animationContext,
        setAnimationContext
      } }
    >
      { children }
    </PlayerContext.Provider>
  )
}
