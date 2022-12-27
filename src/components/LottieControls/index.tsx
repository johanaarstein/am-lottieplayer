import React, { Dispatch, SetStateAction } from 'react';
import { InspectorControls } from '@wordpress/block-editor'; //FocalPointPicker,

import AdvancedSettings from './AdvancedSettings';
import AnimationSettings from './AnimationSettings';
import BackgroundSettings from './BackgroundSettings';

import { LottiePlayer } from '../../global.d';

type LottieControlsProps = {
	attributes: LottiePlayer;
	setAttributes: Dispatch< SetStateAction< Partial< LottiePlayer > > >;
};

export default function LottieControls( {
	attributes,
	setAttributes,
}: LottieControlsProps ) {
	return (
		<InspectorControls>
			<AnimationSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<BackgroundSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<AdvancedSettings
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
		</InspectorControls>
	);
}
