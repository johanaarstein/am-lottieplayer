import type { BlockSaveProps } from '@wordpress/blocks'

import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor'

import type { PlayerComponentProps } from '@/types'

import { Align } from '@/enums'

export default function save( { attributes }: BlockSaveProps< PlayerComponentProps > ) {
  const heightWithUnit =
			attributes.height && attributes.heightUnit
			  ? `${ attributes.height }${ attributes.heightUnit }`
			  : attributes.height,
    style = {
      minHeight: attributes.fullscreen
        ? '100vh'
        : heightWithUnit || undefined,
    },
    parseWidth = ( num: number ) => {
      if (
        attributes.align === Align.Wide ||
        attributes.align === Align.Full
      ) {
        return '100%'
      }
      if ( num && typeof num === 'number' ) {
        return `${ num }px`
      }
    }

  return (
    <div { ...useBlockProps.save( { style } ) }>
      <span
        aria-hidden="true"
        className={ 'wp-block-gb-lottiecover__background' }
        style={ { backgroundColor: attributes.background } }
      />
      <dotlottie-player
        controls={ attributes.controls ? '' : null }
        data-click={ attributes.clickEvent }
        data-delay={ attributes.scrollDelay }
        data-direction={ attributes.direction }
        data-mouseout={ attributes.mouseout }
        data-mouseover={ attributes.hover }
        data-once={ attributes.once }
        data-scroll={ attributes.scrollEvent }
        description={ attributes.alt }
        direction={ attributes.direction }
        intermission={ attributes.intermission }
        loop={ attributes.loop ? '' : null }
        mode={ attributes.mode }
        objectfit={ attributes.objectFit }
        simple={ attributes.simple }
        speed={ attributes.speed }
        src={ attributes.src || '' }
        subframe={ attributes.subframe ? '' : null }
        autoplay={
          attributes.autoplay && ! attributes.scrollEvent ? '' : null
        }
        class={ `lottie-element${
          attributes.selector?.id ? ' has-selector' : ''
        }` }
        style={ {
          backgroundColor: attributes.background,
          height:
						attributes.height &&
						typeof attributes.height === 'number'
						  ? `${ attributes.height }px`
						  : undefined,
          width: parseWidth( attributes.width as number ),
        } }
      />
      <div
        { ...useInnerBlocksProps.save( { className: 'wp-block-gb-lottiecover__inner-container' } ) }
      />
    </div>
  )
}
