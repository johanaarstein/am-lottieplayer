import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import './style.scss';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie } from './assets/icons';

registerBlockType( metadata.name, {
	icon: Lottie,
	keywords: [
		__( 'animation' ),
		__( 'gif' ),
		__( 'motion' ),
		__( 'vector' ),
	],
	attributes: {
		align: {
			type: 'string',
			default: 'none',
		},
		alt: {
			type: 'string',
			default: 'Lottie animation',
		},
		autoplay: {
			type: 'boolean',
			default: true,
		},
		background: {
			type: 'string',
			default: 'transparent',
		},
		controls: {
			type: 'boolean',
			default: true,
		},
		direction: {
			type: 'number',
			default: 1,
		},
		id: {
			type: 'string',
			default: '',
		},
		loop: {
			type: 'boolean',
			default: false,
		},
		mode: {
			type: 'string',
			default: 'normal',
		},
		objectFit: {
			type: 'string',
			default: 'contain',
		},
		src: {
			type: 'string',
		},
	},

	edit: Edit,

	save,
} );
