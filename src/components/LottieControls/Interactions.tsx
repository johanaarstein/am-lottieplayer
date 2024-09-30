import type { PlayerComponentProps } from '@types';
import type { BlockEditProps } from '@wordpress/blocks';

import ProFeature from '@assets/ProFeature';
import { SwitchLabel, TextInput } from '@components/form';
import ProLink from '@components/ProLink';
import { OnMouseOut } from '@utils';
import {
	Panel,
	PanelBody,
	RangeControl,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const Interactions = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const {
		clickEvent,
		hover,
		mouseout,
		once,
		scrollDelay,
		scrollEvent,
		selector,
	} = attributes;

	return (
		<Panel>
			<PanelBody
				className="am-lottieplayer-settings"
				initialOpen={ true }
				title={ __( 'Interactions', 'am-lottieplayer' ) }
			>
				<SwitchLabel
					disabled
					id={ 'am-lottieplayer-animateOnScroll-settings' }
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
								{ __( 'Animate on scroll', 'am-lottieplayer' ) }
							</span>
							<ProFeature />
						</>
					}
					value={ false }
				/>
				<SwitchLabel
					id="am-lottieplayer-click-settings"
					onChange={ ( value ) =>
						setAttributes( { clickEvent: value } )
					}
					title={ __( 'Play on click', 'am-lottieplayer' ) }
					value={ clickEvent }
				/>
				<SwitchLabel
					id="am-lottieplayer-hover-settings"
					onChange={ ( value ) => setAttributes( { hover: value } ) }
					title={ __( 'Play on mouseover', 'am-lottieplayer' ) }
					value={ hover }
				/>
				{ hover && (
					<SelectControl
						label={ __( 'On mouseout', 'am-lottieplayer' ) }
						onChange={ ( val ) =>
							setAttributes( { mouseout: val as OnMouseOut } )
						}
						options={ [
							{
								label: __( 'No event', 'am-lottieplayer' ),
								value: OnMouseOut.Void,
							},
							{
								label: __( 'Stop', 'am-lottieplayer' ),
								value: OnMouseOut.Stop,
							},
							{
								label: __( 'Pause', 'am-lottieplayer' ),
								value: OnMouseOut.Pause,
							},
							{
								label: __( 'Reverse', 'am-lottieplayer' ),
								value: OnMouseOut.Reverse,
							},
						] }
						value={ mouseout }
					/>
				) }
				{ ( hover || clickEvent ) && (
					<>
						<TextInput
							disabled
							help={ __(
								'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.',
								'am-lottieplayer'
							) }
							id="am-lottieplayer-settings"
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, id: val },
								} )
							}
							placeholder={ '#' }
							title={
								<>
									<span
										className="pro-feature"
										style={ { marginRight: '1em' } }
									>
										{ __(
											'Trigger element',
											'am-lottieplayer'
										) }
									</span>

									<ProFeature />
								</>
							}
							value={ selector?.id }
						/>
						<SwitchLabel
							disabled
							id="am-lottieplayer-selector-settings"
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, exclude: val },
								} )
							}
							title={
								<>
									<span
										className="pro-feature"
										style={ {
											display: 'block',
											marginBottom: '1em',
										} }
									>
										{ __(
											'Apply interaction only to trigger element',
											'am-lottieplayer'
										) }
									</span>
									<ProFeature />
								</>
							}
							value={ selector?.exclude }
						/>
					</>
				) }
				<SwitchLabel
					id="am-lottieplayer-scroll-settings"
					onChange={ ( value ) =>
						setAttributes( { scrollEvent: value } )
					}
					title={ __(
						'Play on scroll, when visible in viewport',
						'am-lottieplayer'
					) }
					value={ scrollEvent }
				/>
				{ scrollEvent && (
					<>
						<SwitchLabel
							id="am-lottieplayer-once-settings"
							onChange={ ( value ) =>
								setAttributes( { once: value } )
							}
							title={ __( 'Play only once', 'am-lottieplayer' ) }
							value={ once }
						></SwitchLabel>
						<RangeControl
							label={ __(
								'Delay, in 10th of a second',
								'am-lottieplayer'
							) }
							max={ 50 }
							min={ 0 }
							onChange={ ( value ) =>
								setAttributes( { scrollDelay: value } )
							}
							step={ 1 }
							value={ scrollDelay ?? 1 }
						/>
					</>
				) }
				<ProLink />
			</PanelBody>
		</Panel>
	);
};

export default Interactions;
