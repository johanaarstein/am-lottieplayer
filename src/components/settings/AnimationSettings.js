import {
	Panel,
	PanelBody,
	PanelRow,
	RangeControl,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { SwitchLabel } from '../form';

const AnimationSettings = ( { attributes, setAttributes } ) => {
	const { controls, interactivityType, loop, speed } = attributes;

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
						setAttributes( { interactivityType: val } );
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
				<PanelRow>
					<RangeControl
						label={ __( 'Speed' ) }
						min={ 0.5 }
						max={ 5 }
						step={ 0.5 }
						value={ speed }
						onChange={ ( value ) =>
							setAttributes( { speed: value } )
						}
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default AnimationSettings;
