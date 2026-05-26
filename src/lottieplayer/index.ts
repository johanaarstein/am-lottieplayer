import { registerBlockType } from '@wordpress/blocks'

import type { PlayerComponentProps } from '@/types'

import icon from '@/assets/Lottie'
import metadata from '@/lottieplayer/block.json'
import Edit from '@/lottieplayer/edit'
import save from '@/lottieplayer/save'
import '@/lottieplayer/style.css'

registerBlockType<PlayerComponentProps>(metadata, {
  edit: Edit,
  icon,
  save,
})
