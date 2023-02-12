import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const AdvanceSettings = ( { attributes, setAttributes } ) => {
	const {
		mode = 'normal',
		objectFit = 'contain',
		renderer = 'svg',
	} = attributes;

	return (
		<InspectorAdvancedControls key="inspector">
			<SelectControl
				label={ __( 'Renderer' ) }
				value={ renderer }
				onChange={ ( val ) => setAttributes( { renderer: val } ) }
				options={ [
					{ value: 'svg', label: 'SVG' },
					{ value: 'canvas', label: 'Canvas' },
				] }
			/>
			<SelectControl
				label={ __( 'Object fit' ) }
				value={ objectFit }
				onChange={ ( val ) => {
					setAttributes( { objectFit: val } );
				} }
				options={ [
					{
						value: 'contain',
						label: __( 'Contain', 'am-lottieplayer' ),
					},
					{ value: 'cover', label: __( 'Cover', 'am-lottieplayer' ) },
					{ value: 'fill', label: __( 'Fill', 'am-lottieplayer' ) },
					{ value: 'none', label: __( 'None', 'am-lottieplayer' ) },
				] }
			/>
			<SelectControl
				label={ __( 'Play mode', 'am-lottieplayer' ) }
				value={ mode }
				name="mode"
				onChange={ ( val ) => setAttributes( { mode: val } ) }
				options={ [
					{
						value: 'normal',
						label: __( 'Normal', 'am-lottieplayer' ),
					},
					{
						value: 'bounce',
						label: __( 'Bounce', 'am-lottieplayer' ),
					},
				] }
			/>
		</InspectorAdvancedControls>
	);
};

export default AdvanceSettings;
