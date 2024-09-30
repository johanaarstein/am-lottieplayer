import { useId } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';

import { usePlayerContext } from '@context/PlayerWrapper';
import Advanced from './Advanced';
import Animation from './Animation';
import Background from './Background';
import Interactions from './Interactions';
import Dimensions from './Dimensions';

import type { BlockEditProps } from '@wordpress/blocks';
import type { PlayerComponentProps } from '@types';

export default function LottieControls( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const generatedId = useId(),
		{
			animationContext: { animations },
			setAnimationContext,
		} = usePlayerContext();

	if ( ! animations.length ) {
		setAnimationContext( ( prev ) => ( {
			...prev,
			animations: [
				{
					autoplay: attributes.autoplay,
					direction: attributes.direction,
					id: attributes.id ?? generatedId,
					loop: attributes.loop,
					mode: attributes.mode,
					speed: attributes.speed,
				},
			],
		} ) );
	}
	return (
		<>
			<InspectorControls>
				<Animation
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
				<Interactions
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
				<Advanced
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
			</InspectorControls>
			<InspectorControls group="styles">
				<Dimensions
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
				<Background
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
			</InspectorControls>
		</>
	);
}
