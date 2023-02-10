import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie } from '../assets/icons';

registerBlockType( metadata.name, {
	icon: Lottie,
	title: metadata.title,
	keywords: [
		__( 'animation', 'am-lottieplayer' ),
		'gif',
		__( 'motion', 'am-lottieplayer' ),
		__( 'vector', 'am-lottieplayer' ),
		'SVG',
		'Lottie',
		'dotLottie',
	],
	attributes: {
		align: {
			type: 'string',
			default: 'none',
		},
		alt: {
			type: 'string',
			default: __( 'AM LottiePlayer animation', 'am-lottieplayer' ),
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
		click: {
			type: 'boolean',
			default: false,
		},
		direction: {
			type: 'number',
			default: 1,
		},
		height: {
			type: 'number',
			default: null,
		},
		hover: {
			type: 'boolean',
			default: false,
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
			default: true,
		},
		mode: {
			type: 'string',
			default: 'normal',
		},
		mouseout: {
			type: 'string',
			default: 'stop',
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
			default: '',
		},
		width: {
			type: 'number',
			default: null,
		},
	},

	edit: Edit,

	save,
} );
