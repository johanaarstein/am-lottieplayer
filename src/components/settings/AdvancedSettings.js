import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { RangeControl, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const AdvanceSettings = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	const { direction, mode, speed } = attributes;

	return (
		<InspectorAdvancedControls key="inspector">
			<RangeControl
				label={ __( 'Speed' ) }
				min={ 0.5 }
				max={ 5 }
				step={ 0.5 }
				value={ speed }
				onChange={ ( value ) => setAttributes( { speed: value } ) }
			/>
			<SelectControl
				label={ __( 'Play mode' ) }
				value={ mode }
				name="mode"
				onChange={ ( val ) => setAttributes( { mode: val } ) }
				options={ [
					{ value: 'normal', label: 'Normal' },
					{ value: 'bounce', label: 'Bounce' },
				] }
			/>
			<SelectControl
				label={ __( 'Direction' ) }
				value={ direction }
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
