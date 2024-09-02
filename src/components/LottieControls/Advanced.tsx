import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { SelectControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import ProFeature from '@assets/ProFeature';
import ProLink from '@components/ProLink';

import type { BlockEditProps } from '@wordpress/blocks';
import type { PlayerComponentProps } from '@types';

const Advanced = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { alt } = attributes;

	return (
		<InspectorAdvancedControls>
			<SelectControl
				label={
					<>
						<span
							className="pro-feature"
							style={ { marginRight: '1em' } }
						>
							{ __( 'Renderer' ) }
						</span>
						<ProFeature />
					</>
				}
				help={ <ProLink /> }
				disabled
				value="svg"
				onChange={ () =>
					console.warn(
						'This feature is only available in the premium version'
					)
				}
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
