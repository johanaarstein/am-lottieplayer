import {
	BlockAlignmentToolbar,
	BlockControls,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';

import {
	AdvancedSettings,
	AnimationSettings,
	BackgroundSettings,
} from '../components/settings';

import Placeholder from '../components/Placeholder';

import './editor.scss';

export const LottieControls = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	const { align } = attributes;
	return (
		<>
			<BlockControls key="Lottie Block Controls">
				<ToolbarGroup>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) =>
							setAttributes( {
								align: value ?? align,
							} )
						}
					/>
				</ToolbarGroup>
			</BlockControls>

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
		</>
	);
};

export default function Edit( {
	attributes = {},
	setAttributes = () => {},
} = {} ) {
	const { align } = attributes;

	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div
				{ ...useBlockProps( {
					className: align !== 'none' ? ' align' + align : '',
				} ) }
			>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
			</div>
		</>
	);
}
