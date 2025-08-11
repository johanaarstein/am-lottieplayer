import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player'
import type { LottieAnimation } from '@aarsteinmedia/lottie-web'

import { createContext, useContext } from '@wordpress/element'

export interface AnimationContext {
  animations: LottieAnimation[];
  player: null | DotLottiePlayer;
}

const PlayerContext = createContext<{
  setAnimationContext: React.Dispatch<React.SetStateAction<AnimationContext>>;
  animationContext: AnimationContext;
}>({
  animationContext: {
    animations: [],
    player: null,
  },
  setAnimationContext: (value: React.SetStateAction<AnimationContext>) =>
    value,
})

export const usePlayerContext = () => useContext(PlayerContext)

export default PlayerContext