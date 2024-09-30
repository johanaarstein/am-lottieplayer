import { useEffect, useState } from '@wordpress/element';
import {
	BaseControl,
	Panel,
	PanelBody,
	PanelRow,
	RangeControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { usePlayerContext } from '@context/PlayerWrapper';
import ProFeature from '@assets/ProFeature';
import ProLink from '@components/ProLink';
import { NumberInput, SwitchLabel } from '@components/form';
// import { PlayMode } from '@utils';

import type { BlockEditProps } from '@wordpress/blocks';
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
			// mode = PlayMode.Normal,
			segment,
			speed = 1,
			subframe,
		} = attributes,
		{
			animationContext: { animations, player },
		} = usePlayerContext(),
		[ state, setState ] = useState( {
			hasMultipleAnimations: false,
			totalFrames: 0,
		} );

	useEffect( () => {
		if ( player ) {
			setState( {
				hasMultipleAnimations: animations?.length > 1,
				totalFrames: Number( player.getLottie()?.totalFrames ?? 0 ),
			} );
		}
	}, [ animations?.length, player ] );

	return (
		<Panel>
			<PanelBody
				className="am-lottieplayer-settings"
				initialOpen={ true }
				title={ __( 'Animation Settings', 'am-lottieplayer' ) }
			>
				{ state.hasMultipleAnimations && (
					<div style={ { marginBottom: '1em' } }>
						<p>
							<ProFeature />
						</p>
						<p>
							{ __(
								'This file contains multiple animations. To control each of them individually you need to upgrade to AM LottiePlayer PRO.',
								'am-lottieplayer'
							) }
						</p>
					</div>
				) }
				<SwitchLabel
					id="am-lottieplayer-controls-settings"
					onChange={ ( value ) =>
						setAttributes( { controls: value } )
					}
					title={ __( 'Show controls', 'am-lottieplayer' ) }
					value={ !! controls }
				/>
				<SwitchLabel
					id="am-lottieplayer-autoplay-settings"
					onChange={ ( value ) => {
						setAttributes( { autoplay: value } );
					} }
					title={ __( 'Autoplay', 'am-lottieplayer' ) }
					value={ !! autoplay }
				/>
				<SwitchLabel
					id="am-lottieplayer-loop-settings"
					onChange={ ( value ) => {
						setAttributes( { loop: value } );
					} }
					title={ __( 'Loop', 'am-lottieplayer' ) }
					value={ !! loop }
				/>
				<SwitchLabel
					disabled
					id="am-lottieplayer-playmode-settings"
					onChange={ () =>
						console.warn(
							'This feature is only available in the premium version'
						)
					}
					title={
						<>
							<span
								className="pro-feature"
								style={ { marginRight: '1em' } }
							>
								{ __( 'Boomerang', 'am-lottieplayer' ) }
							</span>
							<ProFeature />
						</>
					}
					value={ false }
				/>
				<SwitchLabel
					id="am-lottieplayer-reverse-settings"
					onChange={ ( value ) =>
						setAttributes( { direction: ! value ? 1 : -1 } )
					}
					title={ __( 'Reverse', 'am-lottieplayer' ) }
					value={ direction === -1 }
				/>
				<SwitchLabel
					id="am-lottieplayer-subframe-settings"
					onChange={ ( value ) =>
						setAttributes( { subframe: value } )
					}
					subTitle={ __(
						'Makes the animation smoother, at the cost of RAM usage',
						'am-lottieplayer'
					) }
					title={ __( 'Subframe', 'am-lottieplayer' ) }
					value={ !! subframe }
				/>
				<RangeControl
					label={ __( 'Speed', 'am-lottieplayer' ) }
					max={ 5 }
					min={ 0.5 }
					onChange={ ( value ) => setAttributes( { speed: value } ) }
					step={ 0.5 }
					value={ speed }
				/>
				<BaseControl.VisualLabel>
					<p>
						<ProFeature />
					</p>
					<span className="pro-feature">
						{ __(
							'Play only part of the animation',
							'am-lottieplayer'
						) }
					</span>
				</BaseControl.VisualLabel>
				<PanelRow className="lottie-segment">
					<NumberInput
						disabled
						id="am-lottieplayer-segment-in"
						onChange={ () =>
							console.warn(
								'This feature is only available in the premium version'
							)
						}
						placeholder={ '1' }
						title={ __( 'First frame', 'am-lottieplayer' ) }
						value={ segment?.[ 0 ] }
					/>
					<NumberInput
						disabled
						id="am-lottieplayer-segment-out"
						onChange={ () =>
							console.warn(
								'This feature is only available in the premium version'
							)
						}
						placeholder={ ( state.totalFrames + 1 ).toString() }
						title={ __( 'Last frame', 'am-lottieplayer' ) }
						value={ segment?.[ 1 ] }
					/>
				</PanelRow>
				<ProLink />
			</PanelBody>
		</Panel>
	);
};

export default Animation;
