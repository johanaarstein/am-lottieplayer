import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { NumberInput, SwitchLabel } from '../form';

const AnimationSettings = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	const {
		align,
		controls,
		height,
		interactivityType,
		loop,
		objectFit,
		width,
	} = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings' ) }
				initialOpen={ true }
			>
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
				<SwitchLabel
					title={ __( 'Loop' ) }
					subTitle={ __( 'Repeat animation' ) }
					value={ loop }
					onChange={ ( value ) => {
						setAttributes( { loop: value } );
					} }
				/>
				<SwitchLabel
					title={ __( 'Controls' ) }
					subTitle={ __( 'Display animation controls' ) }
					value={ controls }
					onChange={ ( value ) => {
						setAttributes( { controls: value } );
					} }
				/>
				<PanelRow className="lottie-dimensions">
					<NumberInput
						title={ __( 'Width' ) }
						value={ ! width || width === '0' ? null : width }
						onChange={ ( val ) => {
							setAttributes( { width: val ?? null } );
						} }
						disabled={ align === 'full' || align === 'wide' }
						placeholder={
							align === 'full' || align === 'wide'
								? '100%'
								: 'auto'
						}
					/>
					<NumberInput
						title={ __( 'Height' ) }
						value={ ! height || height === '0' ? null : height }
						onChange={ ( val ) => {
							setAttributes( { height: val ?? null } );
						} }
						placeholder={ 'auto' }
					/>
				</PanelRow>
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
			</PanelBody>
		</Panel>
	);
};

export default AnimationSettings;
