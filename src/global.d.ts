import { Dispatch, SetStateAction } from 'react';
import { DotLottiePlayer } from '@johanaarstein/dotlottie-player';

declare global {
  namespace JSX {
    interface IntrinsicElements {
      "dotlottie-player": any
    }
  }
}

export interface LottiePlayer extends DotLottiePlayer {
  align?: string,
  allowedBlocks?: Array<string>,
  alt: string,
  background?: string,
  content?: string,
  dimRatio: number | null,
  focalPoint?: Object,
  fontSize?: string,
  height: number | null,
  heightUnit?: string,
  mouseout?: string,
  objectFit?: string,
  overlayColor?: string,
  src: string,
  templateLock?: Record<string, Boolean>,
  width: number | null,
}

export interface MediaObject {
  id: string,
  url: string,
  alt?: string,
}

export interface EditProps {
  attributes: LottiePlayer,
  clientId?: string,
  isSelected: boolean,
  setAttributes: Dispatch<SetStateAction<Partial<LottiePlayer>>>,
  toggleSelection: (value: boolean) => void,
}