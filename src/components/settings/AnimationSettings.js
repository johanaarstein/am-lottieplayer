import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { InputLabel, SwitchLabel } from '../form';

const AnimationSettings = ( { attributes, setAttributes } ) => {
	const { controls, interactivityType, loop } = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings' ) }
				initialOpen={ true }
			>
				<SelectControl
					label={ __( 'Play animation on' ) }
					value={ interactivityType }
					onChange={ ( val ) =>
						setAttributes( {
							...attributes,
							interactivityType: val,
						} )
					}
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
						const newValue = value ?? false;
						setAttributes( { loop: newValue } );
					} }
				/>
				<SwitchLabel
					title={ __( 'Controls' ) }
					subTitle={ __( 'Display animation controls' ) }
					value={ controls }
					onChange={ ( value ) => {
						setAttributes( { controls: value ?? null } );
					} }
				/>
				<PanelRow>
					<InputLabel
						label={ __( 'Speed' ) }
						type="number"
						min="0"
						max="5"
						value={ attributes.speed }
						onChange={ ( value ) =>
							setAttributes( { speed: value } )
						}
					/>
					<input
						type="range"
						value={ attributes.speed }
						max="5"
						onChange={ ( { target } ) =>
							setAttributes( { speed: target.value } )
						}
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default AnimationSettings;
