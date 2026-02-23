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

interface LottieAsset {
  /** Whether the data is encoded or not. */
  e: 0 | 1
  /** Name of asset – e.g. Image_0 / audio_0. */
  id: string
  /** Filename – e.g image_0.png / audio_0.mp3 | DataURL, Base64 encoded. */
  p: string
  u: string
}

export interface LottieJSON {
  assets?: LottieAsset[]
  ddd: number
  /** Frames per second, natively. */
  fr: number
  /** Height of animation in pixels. */
  h: number
  ip: number
  layers: unknown[]
  markers: unknown[]
  meta: {
    a: string
    d: string
    /** Generator. */
    g: string
    k: string
    tc: string
  }
  /** Name of animation, from rendering. */
  nm: string
  /** Total number of frames. */
  op: number
  /** Version. */
  v: string
  /** Width of animation in pixels. */
  w: number
}

interface PHPVars {
  endpoint: string
  nonce: string
  pluginUrl: string
}

export interface Attachment {
  alt?: string
  caption?: string
  description?: string
  filename: string
  filesizeHumanReadable: string
  filesizeInBytes: number
  icon: string
  id: number
  lottieJSON: LottieJSON[]
  mime: string
  name: string
  subtype: string
  title: string
  type: string
  url: string
}

interface AttachmentObj {toJSON: () => Attachment}

interface MediaState {get: ( event: string ) => AttachmentObj[]}

export interface MediaElement {
  alt?: string
  id: number
  url?: string
}

export interface Media {
  [ x: string ]: unknown
  on: ( event: string, callback: () => unknown ) => void
  open: () => void
  state: () => MediaState
}

interface MediaOptions {
  button: { text: string }
  library: { type?: string[] }
  multiple: boolean
  title: string
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

interface WP {
  [x: string]: unknown
  media: (options: MediaOptions) => Media
  // on: () => unknown
}


declare global {
  const aamdPHPVariables: PHPVars | undefined

  interface HTMLElementTagNameMap { [tagName]: DotLottiePlayerLight }

  function dotLottiePlayer(): DotLottiePlayerLight
  const wp: WP
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
