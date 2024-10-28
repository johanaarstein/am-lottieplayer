import type { PlayerComponentProps } from '@/types';

import icon from '@/assets/Lottie';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit';
import save from './save';
import './style.scss';

// eslint-disable-next-line @typescript-eslint/no-unsafe-argument, @typescript-eslint/no-explicit-any
registerBlockType< PlayerComponentProps >( metadata as any, {
	edit: Edit,
	icon,
	save,
} );
