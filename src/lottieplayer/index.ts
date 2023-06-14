import { registerBlockType } from '@wordpress/blocks';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie as icon } from '@assets/icons';

import type { PlayerComponentProps } from '@types';

registerBlockType< PlayerComponentProps >( metadata, {
	icon,
	edit: Edit,
	save,
} );
