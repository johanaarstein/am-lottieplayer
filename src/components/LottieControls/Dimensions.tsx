import { useCallback } from '@wordpress/element';
import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { NumberInput, SwitchLabel } from '@components/form';
import { Align } from '@utils';

import type { BlockEditProps } from '@wordpress/blocks';
import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light';
import type { PlayerComponentProps } from '@types';

const Dimensions = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const {
		align,
		fullscreen,
		height,
		objectFit = 'contain',
		width,
	} = attributes;

	const parseWidth = useCallback(
		( num: number | string ) => {
			if ( align === Align.Full || align === Align.Wide ) {
				return '100%';
			}
			return ! num || num === '0' ? undefined : num;
		},
		[ align ]
	);

	return (
		<Panel>
			<PanelBody
				className="am-lottieplayer-settings"
				initialOpen={ true }
				title={ __( 'Dimensions', 'am-lottieplayer' ) }
			>
				{ ( ! fullscreen || align !== Align.Full ) && (
					<PanelRow className="lottie-dimensions">
						<NumberInput
							disabled={
								align === Align.Full || align === Align.Wide
							}
							id="am-lottieplayer-width-settings"
							onChange={ ( val ) =>
								setAttributes( { width: val ?? null } )
							}
							placeholder={
								align === Align.Full || align === Align.Wide
									? '100%'
									: 'auto'
							}
							title={ __( 'Width', 'am-lottieplayer' ) }
							value={ parseWidth( width as number ) }
						/>
						<NumberInput
							disabled={ fullscreen }
							id="am-lottieplayer-height-settings"
							onChange={ ( val ) =>
								setAttributes( { height: val } )
							}
							placeholder={ 'auto' }
							title={ __( 'Height', 'am-lottieplayer' ) }
							value={
								! height || height.toString() === '0'
									? undefined
									: height
							}
						/>
					</PanelRow>
				) }
				{ ( align === Align.Full || align === Align.Wide ) && (
					<SwitchLabel
						id="am-lottieplayer-fullscreen-settings"
						onChange={ ( value ) =>
							setAttributes( { fullscreen: value } )
						}
						title={ __( 'Fill screen', 'am-lottieplayer' ) }
						value={ fullscreen }
					/>
				) }
				<SelectControl
					label={ __( 'Object fit' ) }
					onChange={ ( val ) => {
						setAttributes( {
							objectFit: val as DotLottiePlayer[ 'objectfit' ],
						} );
					} }
					options={ [
						{
							label: __( 'Contain', 'am-lottieplayer' ),
							value: 'contain',
						},
						{
							label: __( 'Cover', 'am-lottieplayer' ),
							value: 'cover',
						},
						{
							label: __( 'Fill', 'am-lottieplayer' ),
							value: 'fill',
						},
						{
							label: __( 'None', 'am-lottieplayer' ),
							value: 'none',
						},
					] }
					value={ objectFit as 'contain' | 'cover' | 'fill' | 'none' }
				/>
			</PanelBody>
		</Panel>
	);
};

export default Dimensions;
