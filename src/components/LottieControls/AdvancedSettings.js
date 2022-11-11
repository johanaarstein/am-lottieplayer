import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { RangeControl, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const AdvanceSettings = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	const { direction, interactivityType, mode, renderer, speed } = attributes;

	return (
		<InspectorAdvancedControls key="inspector">
			<SelectControl
				label={ __( 'Renderer' ) }
				value={ renderer }
				onChange={ ( val ) => setAttributes( { renderer: val } ) }
				options={ [
					{ value: 'svg', label: __( 'SVG' ) },
					{ value: 'canvas', label: __( 'Canvas' ) },
				] }
			/>
			<SelectControl
				label={ __( 'Play animation on' ) }
				value={ interactivityType }
				onChange={ ( val ) => {
					setAttributes( {
						interactivityType: val,
						autoplay: val === 'none',
					} );
				} }
				options={ [
					{ value: 'none', label: __( 'Page Load' ) },
					{ value: 'hold', label: __( 'Hover' ) },
					{ value: 'click', label: __( 'Click' ) },
					{ value: 'scroll', label: __( 'Scroll' ) },
				] }
			/>
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
