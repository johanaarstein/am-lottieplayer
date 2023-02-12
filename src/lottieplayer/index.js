import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import save from './save';
import metadata from './block.json';
import { Lottie } from '../assets/icons';

registerBlockType( metadata, {
	icon: Lottie,
	keywords: [
		__( 'animation', 'am-lottieplayer' ),
		'gif',
		__( 'motion', 'am-lottieplayer' ),
		__( 'vector', 'am-lottieplayer' ),
		'SVG',
		'Lottie',
		'dotLottie',
	],
	edit: Edit,
	save,
} );
