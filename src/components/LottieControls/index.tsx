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
					id: attributes.id ?? generatedId,
					autoplay: attributes.autoplay,
					loop: attributes.loop,
					direction: attributes.direction,
					mode: attributes.mode,
					speed: attributes.speed,
				},
			],
		} ) );
	}
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
