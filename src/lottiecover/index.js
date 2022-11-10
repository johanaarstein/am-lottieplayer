import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import './style.scss';

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
		__( 'cover' ),
		__( 'background' ),
	],
	attributes: {
		align: {
			type: 'string',
			default: 'none',
		},
		alt: {
			type: 'string',
			default: __('Lottie animation'),
		},
		autoplay: {
			type: 'boolean',
			default: true,
		},
		controls: {
			type: 'boolean',
			default: false,
		},
		direction: {
			type: 'number',
			default: 1,
		},
		focalPoint: {
			type: 'object'
		},
		id: {
			type: 'string',
			default: null,
		},
		loop: {
			type: 'boolean',
			default: false,
		},
		minHeight: {
			type: 'number',
		},
		minHeightUnit: {
			type: 'string',
			default: 'px',
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
	},

	edit: Edit,

	save,
} );
