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
        simple
        controls={attributes.controls ? '' : null}
        playOnClick={attributes.playOnClick ? '' : null}
        delay={attributes.delay}
        mouseout={attributes.mouseout}
        hover={attributes.hover ? '' : null}
        once={attributes.once ? '' : null}
        playOnVisible={attributes.playOnVisible ? '' : null}
        description={attributes.description}
        direction={attributes.direction}
        id={`dotlottie-${attributes.id}`}
        intermission={attributes.intermission}
        loop={attributes.loop ? '' : null}
        objectfit={attributes.objectFit}
        speed={attributes.speed}
        src={attributes.src || ''}
        subframe={attributes.subframe ? '' : null}
        autoplay={
          attributes.autoplay && !attributes.playOnVisible ? '' : null
        }
        class={`lottie-element${attributes.selector ? ' has-selector' : ''
          }`}
      />
    </figure>
  )
}
