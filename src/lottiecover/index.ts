import { registerBlockType } from '@wordpress/blocks'

import type { PlayerComponentProps } from '@/types'

import icon from '@/assets/Lottie'
import metadata from '@/lottiecover/block.json'
import Edit from '@/lottiecover/edit'
import save from '@/lottiecover/save'
import '@/lottiecover/style.css'

registerBlockType<PlayerComponentProps>(metadata, {
  edit: Edit,
  icon,
  save,
})
