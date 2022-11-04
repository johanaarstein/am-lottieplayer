// import { __ } from '@wordpress/i18n'
// import { useCallback, useEffect, useState, useRef } from '@wordpress/element'

// import { Popover, TextControl, ToolbarButton } from '@wordpress/components'

import {
	BlockAlignmentToolbar,
	BlockControls,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';

import { AdvancedSettings, AnimationSettings } from './components/settings';

import Placeholder from './components/Placeholder';

// import { displayShortcut, isKeyboardEvent } from '@wordpress/keycodes'
// import { link, linkOff } from '@wordpress/icons'
// import { useMergeRefs } from '@wordpress/compose'

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
				{ ...useBlockProps() }
				className={ `wp-block${
					align !== 'none' ? ' align' + align : ''
				}` }
			>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
			</div>
		</>
	);
}
