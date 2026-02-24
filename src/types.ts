import type DotLottiePlayerLight from '@aarsteinmedia/dotlottie-player/light'
import type { AnimationSegment } from '@aarsteinmedia/lottie-web'
import type { EditorTemplateLock } from '@wordpress/block-editor'
import type { BlockEditProps } from '@wordpress/blocks'
import type { ResizeStartCallback } from 're-resizable'
import type { ReactNode } from 'react'

import type { Align, tagName } from '@/enums'

export interface Interactions {
  delay?: DotLottiePlayerLight['delay']
  hover?: DotLottiePlayerLight['hover']
  mouseout?: DotLottiePlayerLight['mouseout']
  once?: DotLottiePlayerLight['once']
  playOnClick?: DotLottiePlayerLight['playOnClick']
  playOnVisible?: DotLottiePlayerLight['playOnVisible']
  selector?: string | null
}


export interface PlayerComponentProps
  extends Partial<DotLottiePlayerLight>,
  Interactions {
  $schema?: string
  align?: Align
  allowedBlocks?: string[]
  alt?: string
  contentPosition?: string
  dimRatio?: number
  focalPoint?: {
    x?: number
    y?: number
  }
  fullscreen?: boolean
  hasParallax?: boolean
  height?: number
  heightUnit?: 'px' | '%'
  id?: string
  isDark?: boolean
  objectFit?: DotLottiePlayerLight[ 'objectfit' ]
  once?: boolean
  segment?: AnimationSegment
  templateLock?: EditorTemplateLock
  width?: number
}

export interface BlockCoverEditProps
  extends BlockEditProps< PlayerComponentProps > {toggleSelection?: ( x: boolean ) => void}

export interface UploadProps {
  children?: ReactNode
  instructions?: string
  mediaId?: number
  onError: ( message: string ) => void
  onSelectMedia: ( value: {
    id: number
    url: string
    alt: string
  } ) => void
}

export interface ResizableCoverProps {
  [ x: string ]: unknown
  children?: ReactNode
  className?: string
  fullscreen?: boolean
  onResize: ( n: number ) => void
  onResizeStart: ResizeStartCallback
  onResizeStop: ( n: number ) => void
  showHandle?: boolean
}

interface PHPVars {
  endpoint: string
  nonce: string
  pluginUrl: string
}

export interface MediaElement {
  alt?: string
  id: number
  url?: string
}

export interface NoticeProps {
  message?: string
  show: boolean
  status: 'success' | 'error' | 'info'
}

export interface LottieBlockAttributes {
  readonly attributes: PlayerComponentProps
  readonly clientId?: string
  readonly setAttributes?: (attrs: Partial<PlayerComponentProps>) => void
}

export type MediaUpload = (options: {
  allowedTypes: string[]
  filesList: FileList | null
  onFileChange: (media: MediaElement[]) => void
  onError: (message: string) => void
}) => void

export interface BlockEditor {
  getBlockIndex: (clientId: string) => number
  getSettings: () => { mediaUpload: MediaUpload }
}


declare global {
  const aamdPHPVariables: PHPVars | undefined

  interface HTMLElementTagNameMap { [tagName]: DotLottiePlayerLight }

  function dotLottiePlayer(): DotLottiePlayerLight
}

declare module 'react' {

  type JSXLottiePlayer = Omit<Partial<DotLottiePlayerLight>, 'style'> & {
    class?: string
    ref?: React.RefObject<unknown>
    style?: React.CSSProperties
    src: string
  }

  namespace JSX {
    interface IntrinsicElements { [tagName]: JSXLottiePlayer }
  }
}
