// import { __ } from '@wordpress/i18n'
// import { useCallback, useEffect, useState, useRef } from '@wordpress/element'

// import { Popover, TextControl, ToolbarButton } from '@wordpress/components'

import {
	AlignmentToolbar,
	BlockControls,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';

import {
	AnimationSettings,
}

// import { displayShortcut, isKeyboardEvent } from '@wordpress/keycodes'
// import { link, linkOff } from '@wordpress/icons'
// import { useMergeRefs } from '@wordpress/compose'

import './editor.scss';

export const LottieControls = ( {
	attributes = {},
	setAttributes = () => {},
} = {} ) => {
	return (
		<>
			<BlockControls key="Lottie Block Controls">
				<ToolbarGroup>
					<AlignmentToolbar
						value={ attributes.contentAlign }
						onChange={ ( value ) =>
							setAttributes({
								contentAlign:
									value === 'undefined'
										? attributes.contentAlign
										: value,
							})
						}
					/>
				</ToolbarGroup>
			</BlockControls>

			<InspectorControls>
				<AnimationSettings attributes={attributes} setAttributes={setAttributes} />
				<BackgroundSettings attributes={attributes} setAttributes={setAttributes} />
				<AdvancedSettings attributes={attributes} setAttributes={setAttributes} />
			</InspectorControls>
		</>
	)
}

export default function Edit({
	attributes = {},
	setAttributes = () => {},
	// isSelected
} = {}) {
	const saveChanges = value => {
		setAttributes({ 
			content: value
		})
	}

	return (
		<>
			<LottieControls
				attributes={attributes}
				setAttributes={setAttributes}
			/>
			<div {...useBlockProps()}>
				<Placeholder
					attributes={attributes}
					setAttributes={setAttributes}
				/>
			</div>
		</>
	)
}
