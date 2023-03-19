import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { SelectControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '../../types';

const Advanced = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { alt, renderer = 'svg' } = attributes;

	return (
		<InspectorAdvancedControls>
			<SelectControl
				label={ __( 'Renderer' ) }
				value={ renderer }
				onChange={ ( val ) => setAttributes( { renderer: val } ) }
				options={ [
					{ value: 'svg', label: 'SVG' },
					{ value: 'canvas', label: 'Canvas' },
				] }
			/>
			<TextareaControl
				label={ __( 'Description', 'am-lottieplayer' ) }
				help={ __(
					'Describe the animation. This is helpful for screen readers and search engines.',
					'am-lottieplayer'
				) }
				value={ alt as string }
				onChange={ ( value ) => setAttributes( { alt: value } ) }
			/>
		</InspectorAdvancedControls>
	);
};

export default Advanced;
