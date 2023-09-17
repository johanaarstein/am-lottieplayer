import { useCallback } from '@wordpress/element';
import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { NumberInput, SwitchLabel } from '@components/form';

import type { BlockEditProps } from 'wordpress__blocks';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player';
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
			if ( align === 'full' || align === 'wide' ) return '100%';
			return ! num || num === '0' ? undefined : num;
		},
		[ align ]
	);

	return (
		<Panel>
			<PanelBody
				title={ __( 'Dimensions', 'am-lottieplayer' ) }
				initialOpen={ true }
			>
				{ ( ! fullscreen || align !== 'full' ) && (
					<PanelRow className="lottie-dimensions">
						<NumberInput
							id="am-lottieplayer-width-settings"
							title={ __( 'Width', 'am-lottieplayer' ) }
							value={ parseWidth( width as number ) }
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
									? undefined
									: height
							}
							disabled={ fullscreen }
							onChange={ ( val ) =>
								setAttributes( { height: val } )
							}
							placeholder={ 'auto' }
						/>
					</PanelRow>
				) }
				{ ( align === 'full' || align === 'wide' ) && (
					<SwitchLabel
						id="am-lottieplayer-fullscreen-settings"
						title={ __( 'Fill screen', 'am-lottieplayer' ) }
						value={ fullscreen }
						onChange={ ( value ) =>
							setAttributes( { fullscreen: value } )
						}
					/>
				) }
				<SelectControl
					label={ __( 'Object fit' ) }
					value={ objectFit }
					onChange={ ( val ) => {
						setAttributes( {
							objectFit: val as DotLottiePlayer[ 'objectfit' ],
						} );
					} }
					options={ [
						{
							value: 'contain',
							label: __( 'Contain', 'am-lottieplayer' ),
						},
						{
							value: 'cover',
							label: __( 'Cover', 'am-lottieplayer' ),
						},
						{
							value: 'fill',
							label: __( 'Fill', 'am-lottieplayer' ),
						},
						{
							value: 'none',
							label: __( 'None', 'am-lottieplayer' ),
						},
					] }
				/>
			</PanelBody>
		</Panel>
	);
};

export default Dimensions;
