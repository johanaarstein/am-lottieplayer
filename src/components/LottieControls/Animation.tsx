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

import type { BlockRefEditProps } from '@types';

const Animation = ( {
	attributes,
	setAttributes,
	refObject,
}: BlockRefEditProps ) => {
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
	const [ state, setState ] = useState( {
		totalFrames: 0,
		hasMultipleAnimations: false,
	} );

	useEffect( () => {
		const { current: animation } = refObject;
		if ( animation ) {
			setState( {
				totalFrames: Number( animation.getLottie()?.totalFrames ?? 0 ),
				hasMultipleAnimations:
					!! animation.getManifest().animations?.length,
			} );
		}
	}, [ refObject ] );

	return (
		<Panel>
			<PanelBody
				title={ __( 'Animation Settings', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				{ state.hasMultipleAnimations && (
					<div style={ { marginBottom: '1em' } }>
						<span className="dashicons dashicons-info-outline" />{ ' ' }
						{ __(
							'This file contains multiple animations.',
							'am-lottieplayer'
						) }
					</div>
				) }
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
											val <= state.totalFrames + 1
												? val
												: state.totalFrames + 1,
									  ]
									: undefined,
							} )
						}
						placeholder={ ( state.totalFrames + 1 ).toString() }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

export default Animation;
