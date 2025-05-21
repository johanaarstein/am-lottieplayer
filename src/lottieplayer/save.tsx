import type { BlockSaveProps } from '@wordpress/blocks'

import { useBlockProps } from '@wordpress/block-editor'

import type { PlayerComponentProps } from '@/types'

export default function save( { attributes }: BlockSaveProps< PlayerComponentProps > ) {
  const blockProps = useBlockProps.save({ className: `align${attributes.align ?? 'none'}` })

  return (
    <figure
      id={ attributes.id }
      {...blockProps}
      style={ {
        ...(blockProps.style as Record<string, string>),
        backgroundColor: attributes.background,
        height:
					! attributes.height || attributes.height === 0
					  ? 'auto'
					  : attributes.height,
        width:
					! attributes.width || attributes.width === 0
					  ? 'auto'
					  : attributes.width,
      } }
    >
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
      />
    </figure>
  )
}
