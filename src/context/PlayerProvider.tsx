import { useState } from '@wordpress/element'

import PlayerContext, { type AnimationContext } from '@/context/PlayerContext'

export default function PlayerWrapper({ children }) {
  const [animationContext, setAnimationContext] =
    useState<AnimationContext>({
      animations: [],
      player: null,
    })

  return (
    <PlayerContext.Provider
      value={{
        animationContext,
        setAnimationContext
      }}
    >
      {children}
    </PlayerContext.Provider>
  )
}
