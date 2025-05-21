import { registerBlockType } from '@wordpress/blocks'

import type { PlayerComponentProps } from '@/types'

import icon from '@/assets/Lottie'
import metadata from '@/lottiecover/block.json'
import Edit from '@/lottiecover/edit'
import save from '@/lottiecover/save'
import '@/lottiecover/style.css'

// eslint-disable-next-line @typescript-eslint/no-unsafe-argument, @typescript-eslint/no-explicit-any
registerBlockType< PlayerComponentProps >( metadata as any, {
  edit: Edit,
  icon,
  save,
} )
