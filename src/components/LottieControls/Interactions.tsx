import {
	Panel,
	PanelBody,
	RangeControl,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import ProFeature from '@assets/ProFeature';
import ProLink from '@components/ProLink';
import { SwitchLabel, TextInput } from '@components/form';
import { OnMouseOut } from '@utils';

import type { BlockEditProps } from '@wordpress/blocks';
import type { PlayerComponentProps } from '@types';

const Interactions = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const {
		clickEvent,
		hover,
		mouseout,
		once,
		scrollEvent,
		scrollDelay,
		selector,
	} = attributes;

	return (
		<Panel>
			<PanelBody
				className="am-lottieplayer-settings"
				title={ __( 'Interactions', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				<SwitchLabel
					id={ 'am-lottieplayer-animateOnScroll-settings' }
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
					disabled
					onChange={ () =>
						console.warn(
							'This feature is only available in the premium version'
						)
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-click-settings"
					title={ __( 'Play on click', 'am-lottieplayer' ) }
					value={ clickEvent }
					onChange={ ( value ) =>
						setAttributes( { clickEvent: value } )
					}
				/>
				<SwitchLabel
					id="am-lottieplayer-hover-settings"
					title={ __( 'Play on mouseover', 'am-lottieplayer' ) }
					value={ hover }
					onChange={ ( value ) => setAttributes( { hover: value } ) }
				/>
				{ hover && (
					<SelectControl
						label={ __( 'On mouseout', 'am-lottieplayer' ) }
						value={ mouseout }
						onChange={ ( val ) =>
							setAttributes( { mouseout: val as OnMouseOut } )
						}
						options={ [
							{
								value: OnMouseOut.Void,
								label: __( 'No event', 'am-lottieplayer' ),
							},
							{
								value: OnMouseOut.Stop,
								label: __( 'Stop', 'am-lottieplayer' ),
							},
							{
								value: OnMouseOut.Pause,
								label: __( 'Pause', 'am-lottieplayer' ),
							},
							{
								value: OnMouseOut.Reverse,
								label: __( 'Reverse', 'am-lottieplayer' ),
							},
						] }
					/>
				) }
				{ ( hover || clickEvent ) && (
					<>
						<TextInput
							id="am-lottieplayer-settings"
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
							help={ __(
								'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.',
								'am-lottieplayer'
							) }
							placeholder={ '#' }
							value={ selector?.id }
							disabled
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, id: val },
								} )
							}
						/>
						<SwitchLabel
							id="am-lottieplayer-selector-settings"
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
							disabled
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, exclude: val },
								} )
							}
						/>
					</>
				) }
				<SwitchLabel
					id="am-lottieplayer-scroll-settings"
					title={ __(
						'Play on scroll, when visible in viewport',
						'am-lottieplayer'
					) }
					value={ scrollEvent }
					onChange={ ( value ) =>
						setAttributes( { scrollEvent: value } )
					}
				/>
				{ scrollEvent && (
					<>
						<SwitchLabel
							id="am-lottieplayer-once-settings"
							title={ __( 'Play only once', 'am-lottieplayer' ) }
							value={ once }
							onChange={ ( value ) =>
								setAttributes( { once: value } )
							}
						></SwitchLabel>
						<RangeControl
							label={ __(
								'Delay, in 10th of a second',
								'am-lottieplayer'
							) }
							min={ 0 }
							max={ 50 }
							step={ 1 }
							value={ scrollDelay ?? 1 }
							onChange={ ( value ) =>
								setAttributes( { scrollDelay: value } )
							}
						/>
					</>
				) }
				<ProLink />
			</PanelBody>
		</Panel>
	);
};

export default Interactions;
