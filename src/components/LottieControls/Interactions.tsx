import { Panel, PanelBody, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { SwitchLabel, TextInput } from '../form';
import { OnMouseOut } from '../../types';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '../../types';

const Interactions = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { clickEvent, hover, mouseout, selector } = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Interactions', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
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
							setAttributes( { mouseout: val } )
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
							title={ __( 'Trigger element', 'am-lottieplayer' ) }
							help={ __(
								'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.',
								'am-lottieplayer'
							) }
							placeholder={ '#' }
							value={ selector?.id }
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, id: val },
								} )
							}
						/>
						<SwitchLabel
							id="am-lottieplayer-selector-settings"
							title={ __(
								'Apply interaction only to trigger element',
								'am-lottieplayer'
							) }
							value={ selector?.exclude }
							onChange={ ( val ) =>
								setAttributes( {
									selector: { ...selector, exclude: val },
								} )
							}
						/>
					</>
				) }
			</PanelBody>
		</Panel>
	);
};

export default Interactions;
