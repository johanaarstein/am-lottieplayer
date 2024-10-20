import type { PlayerComponentProps } from '@/types';

import icon from '@/assets/Lottie';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit';
import save from './save';
import './style.scss';

registerBlockType< PlayerComponentProps >( metadata, {
	edit: Edit,
	icon,
	save,
} );
