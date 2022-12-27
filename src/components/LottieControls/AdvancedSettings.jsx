import React from 'react';
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
					{ value: 'svg', label: __( 'SVG' ) },
					{ value: 'canvas', label: __( 'Canvas' ) },
				] }
			/>
			{ /* <SelectControl
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
			/> */ }
			<SelectControl
				label={ __( 'Object fit' ) }
				value={ objectFit }
				onChange={ ( val ) => {
					setAttributes( { objectFit: val } );
				} }
				options={ [
					{ value: 'contain', label: __( 'Contain' ) },
					{ value: 'cover', label: __( 'Cover' ) },
					{ value: 'fill', label: __( 'Fill' ) },
					{ value: 'none', label: __( 'None' ) },
				] }
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
		</InspectorAdvancedControls>
	);
};

export default AdvanceSettings;
