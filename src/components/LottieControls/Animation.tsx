import {
	BaseControl,
	Panel,
	PanelBody,
	PanelRow,
	RangeControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { PlayMode } from '@types';

import { NumberInput, SwitchLabel } from '@components/form';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

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
		segment,
		speed = 1,
		subframe,
	} = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				<SwitchLabel
					id="am-lottieplayer-controls-settings"
					title={ __( 'Show controls', 'am-lottieplayer' ) }
					value={ !! controls }
					onChange={ ( value ) =>
						setAttributes( { controls: value } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-autoplay-settings"
					title={ __( 'Autoplay', 'am-lottieplayer' ) }
					value={ !! autoplay }
					onChange={ ( value ) => {
						setAttributes( { autoplay: value } );
					} }
				/>
				<SwitchLabel
					id="am-lottieplayer-loop-settings"
					title={ __( 'Loop', 'am-lottieplayer' ) }
					value={ !! loop }
					onChange={ ( value ) => {
						setAttributes( { loop: value } );
					} }
				/>
				<SwitchLabel
					id="am-lottieplayer-playmode-settings"
					title={ __( 'Boomerang', 'am-lottieplayer' ) }
					value={ mode === PlayMode.Bounce }
					onChange={ ( value ) => {
						setAttributes( {
							mode: value ? PlayMode.Bounce : PlayMode.Normal,
						} );
					} }
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
					id="am-lottieplayer-subframe-settings"
					title={ __( 'Subframe', 'am-lottieplayer' ) }
					subTitle={ __(
						'Enabling this can sometimes reduce flicker',
						'am-lottieplayer'
					) }
					value={ !! subframe }
					onChange={ ( value ) =>
						setAttributes( { subframe: value } )
					}
				/>
				<RangeControl
					label={ __( 'Speed', 'am-lottieplayer' ) }
					min={ 0.5 }
					max={ 5 }
					step={ 0.5 }
					value={ speed }
					onChange={ ( value ) => setAttributes( { speed: value } ) }
				/>
				<BaseControl.VisualLabel>
					{ __(
						'Play only part of the animation',
						'am-lottieplayer'
					) }
				</BaseControl.VisualLabel>
				<PanelRow className="lottie-segment">
					<NumberInput
						id="am-lottieplayer-segment-in"
						title={ __(
							'Choose where to start',
							'am-lottieplayer'
						) }
						value={ segment?.[ 0 ] }
						onChange={ ( val ) =>
							setAttributes( {
								segment:
									val !== undefined
										? [ val, segment?.[ 1 ] ?? 0 ]
										: undefined,
							} )
						}
						placeholder={ __( 'First frame', 'am-lottieplayer' ) }
					/>
					<NumberInput
						id="am-lottieplayer-segment-out"
						title={ __( 'And where to end', 'am-lottieplayer' ) }
						value={ segment?.[ 1 ] }
						onChange={ ( val ) =>
							setAttributes( {
								segment: val
									? [ segment?.[ 0 ] ?? 0, val ]
									: undefined,
							} )
						}
						placeholder={ __( 'Last frame', 'am-lottieplayer' ) }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default Animation;
