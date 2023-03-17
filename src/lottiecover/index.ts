import { registerBlockType } from '@wordpress/blocks';

import './style.scss';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie } from '../assets/icons';

import type { PlayerComponentProps } from '../types';

registerBlockType< PlayerComponentProps >( metadata, {
	icon: Lottie,
	edit: Edit,
	save,
} );
