import { __ } from '@wordpress/i18n';
import { useCallback, useEffect, useState, useRef } from '@wordpress/element';

import '@johanaarstein/dotlottie-player'

// import { Popover, TextControl, ToolbarButton } from '@wordpress/components';

import {
	// BlockControls,
	// InspectorControls,
	// RichText,
	useBlockProps,
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';

import { /*displayShortcut,*/ isKeyboardEvent } from '@wordpress/keycodes';
// import { link, linkOff } from '@wordpress/icons';
import { useMergeRefs } from '@wordpress/compose';

import './editor.scss';

export default function Edit( { attributes, setAttributes, isSelected } ) {
	const { content, option, url } = attributes,
		// onSetOption = useCallback(
		// 	( value ) => {
		// 		setAttributes( { option: value } );
		// 	},
		// 	[ setAttributes ]
		// ),
		ref = useRef(),
		richTextRef = useRef(),
		onKeyDown = ( event ) => {
			if ( isKeyboardEvent.primary( event, 'k' ) ) {
				startEditing( event );
			} else if ( isKeyboardEvent.primaryShift( event, 'k' ) ) {
				unlink();
				richTextRef.current?.focus();
			}
		},
		// [ popoverAnchor, setPopoverAnchor ] = useState( null ),
		blockProps = useBlockProps( {
			ref: useMergeRefs( [ setPopoverAnchor, ref ] ),
			onKeyDown,
		} ),
		// [ isEditingURL, setIsEditingURL ] = useState( false ),
		// isURLSet = !! url,
		// saveChanges = ( value ) => {
		// 	setAttributes( { content: value } );
		// },
		startEditing = ( event ) => {
			event.preventDefault();
			setIsEditingURL( true );
		},
		unlink = () => {
			setAttributes( {
				url: undefined,
			} );
			setIsEditingURL( false );
		};

	useEffect( () => {
		if ( ! isSelected ) {
			setIsEditingURL( false );
		}
	}, [ isSelected ] );

	return (
		<div { ...blockProps }>
			<dotlottie-player
				autoplay
				loop
				src="https://storage.googleapis.com/aarsteinmedia/intro.lottie"
			/>
		</div>
	);
}
