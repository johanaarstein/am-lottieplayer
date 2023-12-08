import { InspectorControls } from '@wordpress/block-editor';

import Advanced from './Advanced';
import Animation from './Animation';
import Background from './Background';
import Interactions from './Interactions';
import Dimensions from './Dimensions';

import type { BlockRefEditProps } from '@types';

export default function LottieControls( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
	refObject,
}: BlockRefEditProps ) {
	return (
		<InspectorControls>
			<Animation
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
				refObject={ refObject }
			/>
			<Interactions
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			<Dimensions
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
