import { useEffect, useState } from '@wordpress/element';
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
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player';

const Animation = ( {
	attributes,
	clientId,
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
	const [ totalFrames, setTotalFrames ] = useState< number | undefined >( 0 );

	useEffect( () => {
		const animationItem: HTMLElement | null =
			document.getElementById( clientId );
		if ( animationItem ) {
			setTotalFrames(
				( animationItem as DotLottiePlayer )?.getLottie()?.totalFrames
			);
		}
	}, [ clientId ] );

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
						title={ __( 'First frame', 'am-lottieplayer' ) }
						value={ segment?.[ 0 ] }
						onChange={ ( val ) =>
							setAttributes( {
								segment:
									val !== undefined
										? [ val, segment?.[ 1 ] ?? 1 ]
										: undefined,
							} )
						}
						placeholder={ '1' }
					/>
					<NumberInput
						id="am-lottieplayer-segment-out"
						title={ __( 'Last frame', 'am-lottieplayer' ) }
						value={ segment?.[ 1 ] }
						onChange={ ( val ) =>
							setAttributes( {
								segment: val
									? [
											segment?.[ 0 ] ?? 1,
											val <= Number( totalFrames ) + 1
												? val
												: Number( totalFrames ) + 1,
									  ]
									: undefined,
							} )
						}
						placeholder={ ( Number( totalFrames ) + 1 ).toString() }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default Animation;
