import React from 'react';
import { InspectorControls } from '@wordpress/block-editor'; //FocalPointPicker,

import AdvancedSettings from './AdvancedSettings';
import AnimationSettings from './AnimationSettings';
import BackgroundSettings from './BackgroundSettings';

export default function LottieControls( { attributes, setAttributes } ) {
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
