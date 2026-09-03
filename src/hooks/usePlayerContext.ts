import { useContext } from '@wordpress/element'

import PlayerContext from '@/context/PlayerContext'

export default function usePlayerContext() {
  return useContext(PlayerContext)
}