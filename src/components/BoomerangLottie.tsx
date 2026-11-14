import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player'

import { useRef } from '@wordpress/element'

import { useEventListener } from '@/hooks/useEventListener'
import { isTouch } from '@/utils'

export default function BoomerangLottie({
  autoplay,
  className = '',
  speed = 1,
  src,
  subframe,
}: Readonly<Partial<DotLottiePlayer>>) {
  const boomerangRef = useRef<DotLottiePlayer>(null),
    mouseOut = () => {
      if (isTouch()) {
        return
      }
      boomerangRef.current?.setDirection(-1)
      boomerangRef.current?.play()
    },
    mouseOver = () => {
      if (isTouch()) {
        return
      }
      boomerangRef.current?.setDirection(1)
      boomerangRef.current?.play()
    },
    touchScroll = () => {
      if (!isTouch() || !boomerangRef.current) {
        return
      }
      if (boomerangRef.current.getBoundingClientRect().top < 150) {
        boomerangRef.current.setDirection(1)
        boomerangRef.current.play()
      } else {
        boomerangRef.current.setDirection(-1)
        boomerangRef.current.play()
      }
    }

  useEventListener(
    'scroll', touchScroll, {
      capture: true,
      passive: true,
    }
  )

  useEventListener(
    'mouseover', mouseOver, { element: boomerangRef }
  )
  useEventListener(
    'mouseout', mouseOut, { element: boomerangRef }
  )

  return (
    <dotlottie-player
      autoplay={autoplay}
      class={className}
      ref={boomerangRef}
      speed={speed}
      src={src ?? ''}
      subframe={subframe}
    />
  )
}
