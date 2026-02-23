import type { BlockSaveProps } from '@wordpress/blocks'

import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor'

import type { PlayerComponentProps } from '@/types'

import { Align } from '@/enums'

export default function save({ attributes }: BlockSaveProps<PlayerComponentProps>) {
  const heightWithUnit =
    attributes.height && attributes.heightUnit
      ? `${attributes.height}${attributes.heightUnit}`
      : attributes.height,
    style = {
      minHeight: attributes.fullscreen
        ? '100vh'
        : heightWithUnit || undefined,
    },
    parseWidth = (num?: number) => {
      if (
        attributes.align === Align.Wide ||
        attributes.align === Align.Full
      ) {
        return '100%'
      }
      if (num && typeof num === 'number') {
        return `${num}px`
      }
    }

  return (
    <div {...useBlockProps.save({ style })}>
      <span
        aria-hidden="true"
        className={'wp-block-gb-lottiecover__background'}
        style={{ backgroundColor: attributes.background }}
      />
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
        style={{
          backgroundColor: attributes.background,
          height:
            attributes.height &&
            typeof attributes.height === 'number'
              ? `${attributes.height}px`
              : undefined,
          width: parseWidth(attributes.width),
        }}
      />
      <div
        {...useInnerBlocksProps.save({ className: 'wp-block-gb-lottiecover__inner-container' })}
      />
    </div>
  )
}
