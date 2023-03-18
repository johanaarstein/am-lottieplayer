import { InspectorControls } from '@wordpress/block-editor';

import Advanced from './Advanced';
import Animation from './Animation';
import Background from './Background';
import Interactions from './Interactions';
import Spacing from './Spacing';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '../../types';

export default function LottieControls( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	return (
		<InspectorControls>
			<Animation
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			<Interactions
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			<Spacing
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			<Background
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			<Advanced
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
		</InspectorControls>
	);
}
