import { ColorPicker, Panel, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const BackgroundSettings = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	const { background } = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Background Settings' ) }
				initialOpen={ false }
			>
				<ColorPicker
					color={ background }
					onChange={ ( color ) => {
						setAttributes( { background: color } );
					} }
				/>
			</PanelBody>
		</Panel>
	);
};

export default BackgroundSettings;
