import { ColorPicker, Panel, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const BackgroundSettings = ( { attributes, setAttributes } ) => {
	const { background } = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Background Color', 'am-lottieplayer' ) }
				initialOpen={ false }
			>
				<ColorPicker
					color={ background }
					onChangeComplete={ ( color ) => {
						return setAttributes( { background: color.hex } );
					} }
				/>
			</PanelBody>
		</Panel>
	);
};

export default BackgroundSettings;
