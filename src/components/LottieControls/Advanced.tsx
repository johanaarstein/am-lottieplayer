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
				disabled
				help={ <ProLink /> }
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
				onChange={ () =>
					console.warn(
						'This feature is only available in the premium version'
					)
				}
				options={ [
					{ label: 'SVG', value: 'svg' },
					{ label: 'Canvas', value: 'canvas' },
				] }
				value="svg"
			/>
			<TextareaControl
				help={ __(
					'Describe the animation. This is helpful for screen readers and search engines.',
					'am-lottieplayer'
				) }
				label={ __( 'Description', 'am-lottieplayer' ) }
				onChange={ ( value ) => setAttributes( { alt: value } ) }
				value={ alt as string }
			/>
		</InspectorAdvancedControls>
	);
};

export default Advanced;
