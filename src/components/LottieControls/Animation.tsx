import {
	Panel,
	PanelBody,
	SelectControl,
	RangeControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { SwitchLabel } from '../form';

import type { BlockEditProps } from 'wordpress__blocks';
import { PlayMode } from '../../types';
import type { PlayerComponentProps } from '../../types';

const Animation = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const {
		autoplay,
		controls,
		direction,
		loop,
		mode = PlayMode.Normal,
		speed = 1,
	} = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				<SwitchLabel
					id="am-lottieplayer-autoplay-settings"
					title={ __( 'Autoplay', 'am-lottieplayer' ) }
					value={ autoplay as boolean }
					onChange={ ( value ) => {
						setAttributes( { autoplay: value } );
					} }
				/>
				<SwitchLabel
					id="am-lottieplayer-loop-settings"
					title={ __( 'Loop', 'am-lottieplayer' ) }
					value={ loop as boolean }
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
					value={ controls as boolean }
					onChange={ ( value ) =>
						setAttributes( { controls: value } )
					}
				/>
				<SelectControl
					label={ __( 'Play mode', 'am-lottieplayer' ) }
					value={ mode }
					name="mode"
					onChange={ ( val ) => setAttributes( { mode: val } ) }
					options={ [
						{
							value: PlayMode.Normal,
							label: __( 'Normal', 'am-lottieplayer' ),
						},
						{
							value: PlayMode.Bounce,
							label: __( 'Boomerang', 'am-lottieplayer' ),
						},
					] }
				/>
			</PanelBody>
		</Panel>
	);
};

export default Animation;
