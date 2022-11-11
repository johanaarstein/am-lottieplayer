import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie } from '../assets/icons';

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
			default: __( 'Lottie animation' ),
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
		height: {
			type: 'number',
			default: null,
		},
		id: {
			type: 'string',
			default: null,
		},
		interactivityType: {
			type: 'string',
			default: 'none',
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
		renderer: {
			type: 'string',
			default: 'svg',
		},
		speed: {
			type: 'number',
			default: 1,
		},
		src: {
			type: 'string',
		},
		width: {
			type: 'number',
			default: null,
		},
	},

	usesContext: [ 'postId', 'postType' ],

	edit: Edit,

	save,
} );
