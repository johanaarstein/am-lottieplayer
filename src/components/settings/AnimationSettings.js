import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { InputLabel, SwitchLabel } from '../form';

const AnimationSettings = ( { attributes, setAttributes } ) => {
	const { controls, loop } = attributes;
	const onChangeMode = ( val ) => {
		switch ( val ) {
			case 'scroll':
				setAttributes( {
					animationType: val,
					interactivitymode: val,
					interactivitytype: 'seek',
					hover: false,
					state: 'none',
					loop: false,
					autoplay: false,
				} );
				break;
			case 'none':
				setAttributes( {
					animationType: val,
					interactivitymode: val,
					interactivitytype: val,
					state: 'autoplay',
					loop: true,
					autoplay: true,
				} );
				break;
			default:
				setAttributes( {
					animationType: val,
					interactivitymode: val,
					interactivitytype: val,
					state: 'none',
					hover: false,
					loop: false,
					autoplay: false,
				} );
		}
	};

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings' ) }
				initialOpen={ true }
			>
				<SelectControl
					label={ __( 'Play animation on' ) }
					value={ attributes.animationType }
					onChange={ ( val ) => onChangeMode( val ) }
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
						const newValue = value ?? null;

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
				{ /* <PanelRow>
          <InputLabel
            label={__('Width')}
            value={attributes.width}
            onChange={value=> setAttributes({ width: value })}
          />
          <InputLabel
            label={__('Height')}
            value={attributes.height}
            onChange={value => setAttributes({ height: value })}
          />
        </PanelRow> */ }
			</PanelBody>
		</Panel>
	);
};

export default AnimationSettings;
