import { registerBlockType } from '@wordpress/blocks';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import icon from '@assets/Lottie';

import type { PlayerComponentProps } from '@types';

registerBlockType< PlayerComponentProps >( metadata, {
	edit: Edit,
	icon,
	save,
} );
