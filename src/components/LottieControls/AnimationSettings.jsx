import { useCallback } from '@wordpress/element';
import {
	Panel,
	PanelBody,
	PanelRow,
	RangeControl,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { NumberInput, SwitchLabel } from '../form';

const AnimationSettings = ( { attributes, setAttributes } ) => {
	const {
		align,
		autoplay,
		controls,
		click,
		direction,
		height,
		hover,
		loop,
		mouseout,
		speed = 1,
		width,
	} = attributes;

	const parseWidth = useCallback(
		( num ) => {
			if ( align === 'full' || align === 'wide' ) return '100%';
			return ! num || num === '0' ? null : num;
		},
		[ align ]
	);

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings' ) }
				initialOpen={ true }
			>
				<SwitchLabel
					id="am-lottieplayer-autoplay-settings"
					title={ __( 'Autoplay' ) }
					value={ autoplay }
					onChange={ ( value ) => {
						setAttributes( { autoplay: value } );
					} }
				/>
				<SwitchLabel
					id="am-lottieplayer-loop-settings"
					title={ __( 'Loop' ) }
					value={ loop }
					onChange={ ( value ) => {
						setAttributes( { loop: value } );
					} }
				/>
				<RangeControl
					label={ __( 'Speed' ) }
					min={ 0.5 }
					max={ 5 }
					step={ 0.5 }
					value={ speed }
					onChange={ ( value ) => setAttributes( { speed: value } ) }
				/>
				<SwitchLabel
					id="am-lottieplayer-reverse-settings"
					title={ __( 'Reverse' ) }
					value={ direction === -1 }
					onChange={ ( value ) =>
						setAttributes( { direction: ! value ? 1 : -1 } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-controls-settings"
					title={ __( 'Show controls' ) }
					value={ controls }
					onChange={ ( value ) =>
						setAttributes( { controls: value } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-click-settings"
					title={ __( 'Play on click' ) }
					value={ click }
					onChange={ ( value ) => setAttributes( { click: value } ) }
				/>
				<SwitchLabel
					id="am-lottieplayer-hover-settings"
					title={ __( 'Play on mouseover' ) }
					value={ hover }
					onChange={ ( value ) => setAttributes( { hover: value } ) }
				/>
				<SelectControl
					label={ __( 'On mouseout' ) }
					value={ mouseout }
					onChange={ ( val ) => setAttributes( { mouseout: val } ) }
					options={ [
						{ value: 'void', label: __( 'No event' ) },
						{ value: 'stop', label: __( 'Stop' ) },
						{ value: 'pause', label: __( 'Pause' ) },
						{ value: 'reverse', label: __( 'Reverse' ) },
					] }
					disabled={ ! hover }
				/>
				<PanelRow className="lottie-dimensions">
					<NumberInput
						id="am-lottieplayer-width-settings"
						title={ __( 'Width' ) }
						value={ parseWidth( width ) }
						onChange={ ( val ) =>
							setAttributes( { width: val ?? null } )
						}
						disabled={ align === 'full' || align === 'wide' }
						placeholder={
							align === 'full' || align === 'wide'
								? '100%'
								: 'auto'
						}
					/>
					<NumberInput
						id="am-lottieplayer-height-settings"
						title={ __( 'Height' ) }
						value={
							! height || height.toString() === '0'
								? null
								: height
						}
						onChange={ ( val ) =>
							setAttributes( { height: val ?? null } )
						}
						placeholder={ 'auto' }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default AnimationSettings;
