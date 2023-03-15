import classnames from 'classnames';

import { useEffect, useRef, useState } from '@wordpress/element';
import {
	useBlockProps,
	useInnerBlocksProps,
	store as blockEditorStore,
	useSetting,
} from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { isBlobURL } from '@wordpress/blob';

import type { EditProps, PlayerComponentProps } from '../types';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';
import ResizableCover from '../components/ResizableCover';

// import { attributesFromMedia, mediaPosition } from '../functions';

import './editor.scss';

const getInnerBlocksTemplate = ( attributes: object ) => [
		[
			'core/paragraph',
			{
				align: 'center',
				placeholder: __( 'Write title…', 'am-lottieplayer' ),
				...attributes,
			},
		],
	],
	isTemporaryMedia = ( id: string, url: string ) => ! id && isBlobURL( url );

export default function Edit( {
	attributes,
	clientId,
	isSelected,
	setAttributes,
	toggleSelection,
}: EditProps ) {
	const {
			allowedBlocks = [
				'core/paragraph',
				'core/heading',
				'core/buttons',
			],
			// alt,
			background,
			// contentPosition,
			// dimRatio,
			// focalPoint,
			// hasParallax,
			height,
			heightUnit = 'px',
			id,
			// isDark,
			src,
			templateLock,
		}: PlayerComponentProps = attributes,
		// { gradientClass, gradientValue } = __experimentalUseGradient(),
		// onSelectMedia = attributesFromMedia( setAttributes, dimRatio ),
		isUploadingMedia = isTemporaryMedia( id as string, src as string ),
		ref = useRef(),
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
		blockProps = useBlockProps( { ref } ),
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: heightWithUnit || undefined,
		},
		// backgroundPosition = focalPoint
		// 	? mediaPosition( focalPoint )
		// 	: undefined,
		// bgStyle = { backgroundColor: overlayColor?.color },
		// mediaStyle = {
		// 	objectPosition: focalPoint
		// 		? mediaPosition( focalPoint )
		// 		: undefined,
		// },
		hasInnerBlocks = useSelect(
			( select ) =>
				!! select( blockEditorStore ).getBlock( clientId ).innerBlocks
					.length,
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
		);

	useEffect( () => {
		setIsPlaceholder( ! src || src === '' );
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
					{ 'is-placeholder': isPlaceholder },
					blockProps.className
				) }
				style={ { ...style, ...blockProps.style } }
			>
				<ResizableCover
					className={ 'block-library-lottiecover__resize-container' }
					onResizeStart={ () => {
						setAttributes( { heightUnit: 'px' } );
						if ( toggleSelection ) toggleSelection( false );
					} }
					onResize={ ( value: number ) => {
						setAttributes( { height: value } );
					} }
					onResizeStop={ ( value: number ) => {
						setAttributes( { height: value } );
						if ( toggleSelection ) toggleSelection( true );
					} }
					showHandle={ isSelected }
				/>
				<span
					aria-hidden="true"
					className={ `wp-block-gb-lottiecover__background` }
					style={ { backgroundColor: background } }
					hidden={ isPlaceholder }
				/>
				{ isUploadingMedia && <Spinner /> }
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
					isPlaceholder={ isPlaceholder }
				/>
				{ ! isPlaceholder && <div { ...innerBlocksProps } /> }
			</div>
		</>
	);
}
