import { registerBlockType } from '@wordpress/blocks'

import type { PlayerComponentProps } from '@/types'

import icon from '@/assets/Lottie'
import metadata from '@/lottieplayer/block.json'
import Edit from '@/lottieplayer/edit'
import save from '@/lottieplayer/save'
import '@/lottieplayer/style.css'

// eslint-disable-next-line @typescript-eslint/no-unsafe-argument, @typescript-eslint/no-explicit-any
registerBlockType< PlayerComponentProps >( metadata as any, {
  edit: Edit,
  icon,
  save,
} )
