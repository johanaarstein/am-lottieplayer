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
				title={ __( 'Animation Settings', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				<SwitchLabel
					id="am-lottieplayer-autoplay-settings"
					title={ __( 'Autoplay', 'am-lottieplayer' ) }
					value={ autoplay }
					onChange={ ( value ) => {
						setAttributes( { autoplay: value } );
					} }
				/>
				<SwitchLabel
					id="am-lottieplayer-loop-settings"
					title={ __( 'Loop', 'am-lottieplayer' ) }
					value={ loop }
					onChange={ ( value ) => {
						setAttributes( { loop: value } );
					} }
				/>
				<RangeControl
					label={ __( 'Speed', 'am-lottieplayer' ) }
					min={ 0.5 }
					max={ 5 }
					step={ 0.5 }
					value={ speed }
					onChange={ ( value ) => setAttributes( { speed: value } ) }
				/>
				<SwitchLabel
					id="am-lottieplayer-reverse-settings"
					title={ __( 'Reverse', 'am-lottieplayer' ) }
					value={ direction === -1 }
					onChange={ ( value ) =>
						setAttributes( { direction: ! value ? 1 : -1 } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-controls-settings"
					title={ __( 'Show controls', 'am-lottieplayer' ) }
					value={ controls }
					onChange={ ( value ) =>
						setAttributes( { controls: value } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-click-settings"
					title={ __( 'Play on click', 'am-lottieplayer' ) }
					value={ click }
					onChange={ ( value ) => setAttributes( { click: value } ) }
				/>
				<SwitchLabel
					id="am-lottieplayer-hover-settings"
					title={ __( 'Play on mouseover', 'am-lottieplayer' ) }
					value={ hover }
					onChange={ ( value ) => setAttributes( { hover: value } ) }
				/>
				<SelectControl
					label={ __( 'On mouseout', 'am-lottieplayer' ) }
					value={ mouseout }
					onChange={ ( val ) => setAttributes( { mouseout: val } ) }
					options={ [
						{
							value: 'void',
							label: __( 'No event', 'am-lottieplayer' ),
						},
						{
							value: 'stop',
							label: __( 'Stop', 'am-lottieplayer' ),
						},
						{
							value: 'pause',
							label: __( 'Pause', 'am-lottieplayer' ),
						},
						{
							value: 'reverse',
							label: __( 'Reverse', 'am-lottieplayer' ),
						},
					] }
					disabled={ ! hover }
				/>
				<PanelRow className="lottie-dimensions">
					<NumberInput
						id="am-lottieplayer-width-settings"
						title={ __( 'Width', 'am-lottieplayer' ) }
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
						title={ __( 'Height', 'am-lottieplayer' ) }
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
