import { useContext } from '@wordpress/element'

import { PlayerContext } from '@/context/PlayerContext'

export function usePlayerContext() {
  return useContext(PlayerContext)
}