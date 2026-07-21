/* eslint-disable @typescript-eslint/naming-convention */
import {
  useBlockProps,
  useInnerBlocksProps,
  store as blockEditorStore,
} from '@wordpress/block-editor'
import { Spinner } from '@wordpress/components'
import { useSelect } from '@wordpress/data'
import { useMemo, useRef } from '@wordpress/element'
import { __ } from '@wordpress/i18n'
import classNames from 'classnames'

import type { BlockCoverEditProps } from '@/types'

import ContextMenu from '@/components/ContextMenu'
import LottieControls from '@/components/LottieControls'
import Placeholder from '@/components/Placeholder'
import ResizableCover from '@/components/ResizableCover'
import '@/lottiecover/editor.css'
import PlayerWrapper from '@/context/PlayerProvider'
import { isTemporaryMedia } from '@/utils/media'

const getInnerBlocksTemplate = (attributes: object) => [
  [
    'core/paragraph', {
      align: 'center',
      placeholder: __('Write title…', 'am-lottieplayer'),
      ...attributes,
    },
  ],
]

export default function Edit({
  attributes,
  className,
  clientId,
  context,
  isSelected,
  setAttributes,
  toggleSelection,
}: BlockCoverEditProps) {
  const {
    allowedBlocks = [
      'core/paragraph',
      'core/heading',
      'core/buttons',
    ],
    // alt,
    background,
    fullscreen,
    // contentPosition,
    // dimRatio,
    // focalPoint,
    // hasParallax,
    height,
    heightUnit = 'px',
    id,
    // isDark,
    src,
    templateLock,
  } = attributes,
    isUploadingMedia = isTemporaryMedia(id, src ?? undefined),
    ref = useRef(),
    isPlaceholder = useMemo(() => !src || src === '', [src]),
    blockProps = useBlockProps({ ref }),
    heightWithUnit =
      height ? `${height}${heightUnit}` : height,
    style = { minHeight: fullscreen ? '100vh' : heightWithUnit || undefined },
    hasInnerBlocks = useSelect((select) =>
      // @ts-expect-error: @wordpress/data is not complete
      // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
      Boolean(select(blockEditorStore).getBlock(clientId)?.innerBlocks.length),
      [clientId]),
    innerBlocksTemplate = getInnerBlocksTemplate({ fontSize: 'large' }),
    innerBlocksProps = useInnerBlocksProps({ className: 'wp-block-gb-lottiecover__inner-container' },
      {
        allowedBlocks,
        template: hasInnerBlocks ? undefined : innerBlocksTemplate as any,
        templateInsertUpdatesSelection: true,
        templateLock,
      })

  return (
    <PlayerWrapper>
      <LottieControls
        attributes={attributes}
        className={className}
        clientId={clientId}
        context={context}
        isSelected={false}
        setAttributes={setAttributes}
      />
      <div
        {...blockProps}
        className={classNames({ 'is-placeholder': isPlaceholder },
          blockProps.className)}
        style={{
          ...style,
          ...blockProps.style
        }}
      >
        <ResizableCover
          className={'block-library-lottiecover__resize-container'}
          fullscreen={fullscreen}
          showHandle={isSelected}
          onResize={(value: number) => {
            setAttributes({ height: value })
          }}
          onResizeStart={() => {
            setAttributes({ heightUnit: 'px' })
            if (toggleSelection) {
              toggleSelection(false)
            }
          }}
          onResizeStop={(value: number) => {
            setAttributes({ height: value })
            if (toggleSelection) {
              toggleSelection(true)
            }
          }}
        />
        <span
          aria-hidden="true"
          className={'wp-block-gb-lottiecover__background'}
          hidden={isPlaceholder}
          style={{ backgroundColor: background }}
        />
        {isUploadingMedia && <Spinner />}
        <Placeholder
          attributes={attributes}
          className={className}
          clientId={clientId}
          context={context}
          isSelected={isSelected}
          setAttributes={setAttributes}
        />
        <ContextMenu
          attributes={attributes}
          setAttributes={setAttributes}
        />
        {!isPlaceholder && <div {...innerBlocksProps} />}
      </div>
    </PlayerWrapper>
  )
}
