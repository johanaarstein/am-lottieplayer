import type { BlockEditProps } from '@wordpress/blocks'

import { InspectorControls } from '@wordpress/block-editor'
import { useEffect, useId } from '@wordpress/element'

import type { PlayerComponentProps } from '@/types'

import Advanced from '@/components/LottieControls/Advanced'
import Animation from '@/components/LottieControls/Animation'
import Background from '@/components/LottieControls/Background'
import Dimensions from '@/components/LottieControls/Dimensions'
import Interactions from '@/components/LottieControls/Interactions'
import { usePlayerContext } from '@/context/PlayerContext'

export default function LottieControls( {
  attributes,
  className,
  clientId,
  context,
  isSelected,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const generatedId = useId(),
    { setAnimationContext } = usePlayerContext()

  useEffect( () => {
    setAnimationContext( ( prev ) => {
      if (prev.animations.length > 0 ) {
        return prev
      }

      return {
        ...prev,
        animations: [
          {
            autoplay: attributes.autoplay,
            direction: attributes.direction,
            id: attributes.id ?? generatedId,
            loop: attributes.loop,
            mode: attributes.mode,
            speed: attributes.speed,
          },
        ],
      }
    } )
  }, [
    attributes.autoplay,
    attributes.direction,
    attributes.id,
    attributes.loop,
    attributes.mode,
    attributes.speed,
    generatedId,
    setAnimationContext,
  ] )

  return (
    <>
      <InspectorControls>
        <Animation
          attributes={ attributes }
          className={ className }
          clientId={ clientId }
          context={ context }
          isSelected={ isSelected }
          setAttributes={ setAttributes }
        />
        <Interactions
          attributes={ attributes }
          className={ className }
          clientId={ clientId }
          context={ context }
          isSelected={ isSelected }
          setAttributes={ setAttributes }
        />
        <Advanced
          attributes={ attributes }
          className={ className }
          clientId={ clientId }
          context={ context }
          isSelected={ isSelected }
          setAttributes={ setAttributes }
        />
      </InspectorControls>
      <InspectorControls group="styles">
        <Dimensions
          attributes={ attributes }
          className={ className }
          clientId={ clientId }
          context={ context }
          isSelected={ isSelected }
          setAttributes={ setAttributes }
        />
        <Background
          attributes={ attributes }
          className={ className }
          clientId={ clientId }
          context={ context }
          isSelected={ isSelected }
          setAttributes={ setAttributes }
        />
      </InspectorControls>
    </>
  )
}
