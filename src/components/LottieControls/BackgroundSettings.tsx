import React, { Dispatch, SetStateAction } from 'react';
import { ColorPicker, Panel, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { LottiePlayer } from '../../global.d';

type BackgroundSettingsProps = {
	attributes: LottiePlayer;
	setAttributes: Dispatch< SetStateAction< Partial< LottiePlayer > > >;
};

const BackgroundSettings = ( {
	attributes,
	setAttributes,
}: BackgroundSettingsProps ) => {
	const { background } = attributes;

	return (
		<Panel>
			<PanelBody title={ __( 'Background Color' ) } initialOpen={ false }>
				<ColorPicker
					color={ background }
					onChangeComplete={ ( color ) => {
						return setAttributes( { background: color.hex } );
					} }
				/>
			</PanelBody>
		</Panel>
	);
};

export default BackgroundSettings;
