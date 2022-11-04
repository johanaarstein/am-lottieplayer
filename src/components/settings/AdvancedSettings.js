import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const AdvanceSettings = ( { attributes, setAttributes } ) => {
	return (
		<InspectorAdvancedControls key="inspector">
			<SelectControl
				label={ __( 'Play mode' ) }
				value={ attributes.mode }
				name="mode"
				onChange={ ( val ) => setAttributes( { mode: val } ) }
				options={ [
					{ value: 'normal', label: 'Normal' },
					{ value: 'bounce', label: 'Bounce' },
				] }
			/>
			<SelectControl
				label={ __( 'Direction' ) }
				value={ attributes.direction }
				onChange={ ( val ) => setAttributes( { direction: val } ) }
				options={ [
					{ value: '1', label: __( 'Forward' ) },
					{ value: '-1', label: __( 'Backward' ) },
				] }
			/>
		</InspectorAdvancedControls>
	);
};

export default AdvanceSettings;
