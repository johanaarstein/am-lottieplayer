import type { PlayerComponentProps } from '@types';

import icon from '@assets/Lottie';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit';
import save from './save';

registerBlockType< PlayerComponentProps >( metadata, {
	edit: Edit,
	icon,
	save,
} );
