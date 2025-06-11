import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light'

import { useEffect, useRef } from '@wordpress/element'

import useEventListener from '@/hooks/useEventListener'
import { isTouch } from '@/utils'

export default function BoomerangLottie( {
  autoplay,
  className = '',
  speed = 1,
  src,
  subframe,
}: Partial< DotLottiePlayer > ) {
  const boomerang = useRef< DotLottiePlayer >( null ),
    mouseOut = () => {
      if ( isTouch() ) {
        return
      }
      boomerang.current?.setDirection( -1 )
      boomerang.current?.play()
    },
    mouseOver = () => {
      if ( isTouch() ) {
        return
      }
      boomerang.current?.setDirection( 1 )
      boomerang.current?.play()
    },
    touchScroll = () => {
      if ( ! isTouch() || ! boomerang.current ) {
        return
      }
      if ( boomerang.current.getBoundingClientRect().top < 150 ) {
        boomerang.current.setDirection( 1 )
        boomerang.current.play()
      } else {
        boomerang.current.setDirection( -1 )
        boomerang.current.play()
      }
    }

  useEventListener(
    'scroll', touchScroll, {
      capture: true,
      passive: true
    }
  )

  // eslint-disable-next-line react-you-might-not-need-an-effect/you-might-not-need-an-effect
  useEffect( () => {
    if (!boomerang.current) {
      return
    }
    boomerang.current.onmouseover = mouseOver
    boomerang.current.onmouseout = mouseOut
  }, [] )

  return (
    <dotlottie-player
      autoplay={ autoplay }
      class={ className }
      ref={ boomerang }
      speed={ speed }
      src={ src ?? '' }
      subframe={ subframe }
    />
  )
}
