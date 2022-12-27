import React from 'react';
import classnames from 'classnames';

import { useEffect, useRef } from '@wordpress/element';
import {
	store as blockEditorStore,
	useBlockProps,
	useInnerBlocksProps,
	useSetting,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';
import ResizableCover from '../components/ResizableCover';

import './editor.scss';

import { EditProps } from '../global.d';

const getInnerBlocksTemplate = ( attributes: any ) => {
	return [
		[
			'core/paragraph',
			{
				align: 'center',
				placeholder: __( 'Write title…' ),
				...attributes,
			},
		],
	];
};

export default function Edit( {
	attributes,
	clientId,
	isSelected,
	setAttributes,
	toggleSelection,
}: EditProps ) {
	const { allowedBlocks, background, height, heightUnit, src, templateLock } =
			attributes,
		isPlaceholder = useRef( true ),
		ref = useRef(),
		blockProps = useBlockProps( { ref } ),
		hasInnerBlocks = useSelect(
			( select ) =>
				select( blockEditorStore ).getBlock( clientId ).innerBlocks
					.length > 0,
			[ clientId ]
		),
		hasFontSizes = !! useSetting( 'typography.fontSizes' )?.length,
		innerBlocksTemplate = getInnerBlocksTemplate( {
			fontSize: hasFontSizes ? 'large' : undefined,
		} ),
		innerBlocksProps = useInnerBlocksProps(
			{
				className: 'wp-block-gb-lottiecover__inner-container',
			},
			{
				template: ! hasInnerBlocks ? innerBlocksTemplate : undefined,
				templateInsertUpdatesSelection: true,
				allowedBlocks,
				templateLock,
			}
		),
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: heightWithUnit || undefined,
		};

	useEffect( () => {
		isPlaceholder.current = ! src || src === '';
	}, [ src ] );

	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div
				{ ...blockProps }
				className={ classnames(
					{ 'is-placeholder': isPlaceholder.current },
					blockProps.className
				) }
				style={ { ...style, ...blockProps.style } }
			>
				<ResizableCover
					className={ 'block-library-lottiecover__resize-container' }
					onResizeStart={ () => {
						setAttributes( { heightUnit: 'px' } );
						toggleSelection( false );
					} }
					onResize={ ( value ) => {
						setAttributes( { height: value } );
					} }
					onResizeStop={ ( value ) => {
						setAttributes( { height: value } );
						toggleSelection( true );
					} }
					showHandle={ isSelected }
				/>
				<span
					aria-hidden="true"
					className={ `wp-block-gb-lottiecover__background` }
					style={ { backgroundColor: background } }
					hidden={ isPlaceholder.current }
				/>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
					isPlaceholder={ isPlaceholder.current }
				/>
				{ ! isPlaceholder.current && <div { ...innerBlocksProps } /> }
			</div>
		</>
	);
}
