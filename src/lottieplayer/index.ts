import { registerBlockType } from '@wordpress/blocks';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { default as icon } from '@assets/Lottie';

import type { PlayerComponentProps } from '@types';

registerBlockType< PlayerComponentProps >( metadata, {
	icon,
	edit: Edit,
	save,
} );
