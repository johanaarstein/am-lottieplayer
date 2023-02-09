import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import './style.scss';

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
		__( 'cover', 'am-lottieplayer' ),
		__( 'background', 'am-lottieplayer' ),
	],
	attributes: {
		align: {
			type: 'string',
			default: 'none',
		},
		allowedBlocks: {
			type: 'array',
			default: [ 'core/paragraph', 'core/heading', 'core/buttons' ],
		},
		alt: {
			type: 'string',
			default: __( 'AM Lottie animation', 'am-lottieplayer' ),
		},
		autoplay: {
			type: 'boolean',
			default: true,
		},
		controls: {
			type: 'boolean',
			default: false,
		},
		content: {
			type: 'string',
			default: '',
		},
		contentPosition: {
			type: 'string',
			default: '',
		},
		click: {
			type: 'boolean',
			default: false,
		},
		dimRatio: {
			type: 'number',
			default: 50,
		},
		direction: {
			type: 'number',
			default: 1,
		},
		focalPoint: {
			type: 'object',
			default: {},
		},
		height: {
			type: 'number',
			default: null,
		},
		heightUnit: {
			type: 'string',
			default: 'px',
		},
		hover: {
			type: 'boolean',
			default: false,
		},
		id: {
			type: 'string',
			default: null,
		},
		loop: {
			type: 'boolean',
			default: true,
		},
		mode: {
			type: 'string',
			default: 'normal',
		},
		objectFit: {
			type: 'string',
			default: 'cover',
		},
		overlayColor: {
			type: 'string',
			default: 'transparent',
		},
		mouseOut: {
			type: 'string',
			default: 'stop',
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
		templateLock: {
			type: [ 'string', 'boolean' ],
			enum: [ 'all', 'insert', 'contentOnly', false ],
		},
		width: {
			type: 'number',
			default: null,
		},
	},
	supports: {
		anchor: true,
		align: true,
		html: false,
		spacing: {
			padding: true,
			margin: [ 'top', 'bottom' ],
			__experimentalDefaultControls: {
				padding: true,
			},
		},
		color: {
			text: false,
			background: false,
		},
		typography: {
			fontSize: true,
			lineHeight: true,
			__experimentalFontFamily: true,
			__experimentalFontWeight: true,
			__experimentalFontStyle: true,
			__experimentalTextTransform: true,
			__experimentalTextDecoration: true,
			__experimentalLetterSpacing: true,
			__experimentalDefaultControls: {
				fontSize: true,
			},
		},
	},

	edit: Edit,

	save,
} );
