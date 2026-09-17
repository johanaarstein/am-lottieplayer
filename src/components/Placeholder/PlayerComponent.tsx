import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player'

import { useSelect } from '@wordpress/data'
import {
  useCallback, useEffect, useRef
} from '@wordpress/element'

import type { BlockEditor, LottieBlockAttributes } from '@/types'

import { Align } from '@/enums'
import { useEventListener } from '@/hooks/useEventListener'
import { usePlayerContext } from '@/hooks/usePlayerContext'
import { debounce } from '@/utils'

const parseSize = (num?: number | null) => {
  if (num && typeof num === 'number') {
    return `${num}px`
  }
}

export default function PlayerComponent({
  attributes,
  clientId = '',
}: LottieBlockAttributes) {
  const {
      animationContext: { player },
      setAnimationContext,
    } = usePlayerContext(),
    { getBlockIndex }: BlockEditor =
      useSelect((select) => select('core/block-editor'), []),
    blockIndex = getBlockIndex(clientId),
    playerRef = useRef<DotLottiePlayer>(null),
    reloadPlayer = useCallback(() => {
      if (!player) {
        return
      }
      void player.reload()
    }, [player]),
    parseWidth = (num?: number | null) => {
      if (
        attributes.align === Align.Wide ||
        attributes.align === Align.Full
      ) {
        return '100%'
      }

      return parseSize(num)
    }

  useEffect(() => {
    if (playerRef.current) {
      setAnimationContext((prev) => ({
        ...prev,
        player: playerRef.current,
      }))
    }
  }, [setAnimationContext])

  useEventListener(
    'ready', () => {
      setAnimationContext((prev) => ({
        ...prev,
        animations: player?.getManifest()?.animations ?? [],
      }))
    }, { element: player }
  )

  useEffect(() => {
    debounce(reloadPlayer, 300)
  }, [
    blockIndex,
    attributes.intermission,
    attributes.src,
    attributes.objectFit,
    reloadPlayer,
  ])

  return (
    <dotlottie-player
      simple
      autoplay={attributes.autoplay ? '' : null}
      class="lottie-element"
      controls={attributes.controls ? '' : null}
      description={attributes.description}
      direction={attributes.direction}
      id={attributes.id}
      intermission={attributes.intermission}
      loop={attributes.loop ? '' : null}
      mode={attributes.mode}
      objectfit={attributes.objectFit}
      ref={playerRef}
      speed={attributes.speed}
      src={attributes.src ?? ''}
      subframe={attributes.subframe ? '' : null}
      style={{
        backgroundColor: attributes.background,
        height: parseSize(attributes.height),
        margin: '0 auto',
        width: parseWidth(attributes.width),
      }}
    />
  )
}
