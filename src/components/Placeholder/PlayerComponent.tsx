import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light'

import { useSelect } from '@wordpress/data'
import {
  useCallback, useEffect, useRef
} from '@wordpress/element'

import type { PlayerComponentProps } from '@/types'

import { usePlayerContext } from '@/context/PlayerWrapper'
import { Align } from '@/enums'
import { debounce } from '@/utils'

const parseSize = (num?: number | null) => {
  if (num && typeof num === 'number') {
    return `${num}px`
  }
}

export default function PlayerComponent( {
  attributes,
  clientId,
}: {
  attributes: PlayerComponentProps;
  clientId: string;
} ) {
  const {
      animationContext: { player },
      setAnimationContext,
    } = usePlayerContext(),
    { getBlockIndex }: { getBlockIndex: ( str: string ) => number } =
			useSelect( ( select ) => select( 'core/block-editor' ), [] ),
    blockIndex = getBlockIndex( clientId ),
    initialRender = useRef( true ),
    playerRef = useRef< DotLottiePlayer >( null ),
    reloadPlayer = useCallback( () => {
      if ( ! player ) {
        return
      }
      void player.reload()
    }, [ player ] ),
    parseWidth = ( num?: number | null ) => {
      if (
        attributes.align === Align.Wide ||
        attributes.align === Align.Full
      ) {
        return '100%'
      }

      return parseSize( num )
    }

  useEffect( () => {
    if ( playerRef.current ) {
      setAnimationContext( ( prev ) => ( {
        ...prev,
        player: playerRef.current,
      } ) )
    }
  }, [ setAnimationContext ] )

  useEffect( () => {
    player?.addEventListener( 'ready', () => {
      setAnimationContext( ( prev ) => ( {
        ...prev,
        animations: player.getManifest()?.animations ?? [],
      } ) )
    } )
  }, [ player, setAnimationContext ] )

  useEffect( () => {
    if ( ! initialRender.current ) {
      debounce( reloadPlayer, 300 )
    }
    initialRender.current = false
  }, [
    blockIndex,
    attributes.intermission,
    attributes.src,
    attributes.objectFit,
    reloadPlayer,
    // segment,
  ] )

  // useEffect( () => {
  // 	if ( attributes.segment ) {
  // 		playerRef.current?.setSegment( attributes.segment );
  // 	}
  // }, [ attributes.segment ] );

  return (
    <dotlottie-player
      simple
      autoplay={ attributes.autoplay ? '' : null }
      class="lottie-element"
      controls={ attributes.controls ? '' : null }
      description={ attributes.alt }
      direction={ attributes.direction }
      id={ attributes.id }
      intermission={ attributes.intermission }
      loop={ attributes.loop ? '' : null }
      mode={ attributes.mode }
      objectfit={ attributes.objectFit }
      ref={ playerRef }
      speed={ attributes.speed }
      src={ attributes.src ?? '' }
      subframe={ attributes.subframe ? '' : null }
      style={ {
        backgroundColor: attributes.background,
        height: parseSize( attributes.height ),
        margin: '0 auto',
        width: parseWidth( attributes.width ),
      } }
    />
  )
}
