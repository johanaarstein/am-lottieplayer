import type { BlockCoverEditProps } from '@/types';
import type { TemplateArray } from '@wordpress/blocks';

import ContextMenu from '@/components/ContextMenu';
import LottieControls from '@/components/LottieControls';
import Placeholder from '@/components/Placeholder';
import ResizableCover from '@/components/ResizableCover';
import PlayerWrapper from '@/context/PlayerWrapper';
import { isTemporaryMedia } from '@/utils';
import {
	useBlockProps,
	useInnerBlocksProps,
	store as blockEditorStore,
	useSetting,
} from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEffect, useRef, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import classNames from 'classnames';

import './editor.scss';

const getInnerBlocksTemplate = ( attributes: object ): TemplateArray => [
	[
		'core/paragraph',
		{
			align: 'center',
			placeholder: __( 'Write title…', 'am-lottieplayer' ),
			...attributes,
		},
	],
];

export default function Edit( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
	toggleSelection,
}: BlockCoverEditProps ) {
	const {
			allowedBlocks = [
				'core/paragraph',
				'core/heading',
				'core/buttons',
			],
			// alt,
			background,
			fullscreen,
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
		} = attributes,
		// { gradientClass, gradientValue } = __experimentalUseGradient(),
		// onSelectMedia = attributesFromMedia( setAttributes, dimRatio ),
		isUploadingMedia = isTemporaryMedia( id as string, src as string ),
		ref = useRef(),
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
		blockProps = useBlockProps( { ref } ),
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: fullscreen ? '100vh' : heightWithUnit || undefined,
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
				!! select( blockEditorStore )?.getBlock( clientId )?.innerBlocks
					?.length,
			[ clientId ]
		),
		fontSizes = useSetting( 'typography.fontSizes' ),
		innerBlocksTemplate = getInnerBlocksTemplate( {
			fontSize: fontSizes ? 'large' : undefined,
		} ),
		innerBlocksProps = useInnerBlocksProps(
			{
				className: 'wp-block-gb-lottiecover__inner-container',
			},
			{
				allowedBlocks,
				template: ! hasInnerBlocks ? innerBlocksTemplate : undefined,
				templateInsertUpdatesSelection: true,
				templateLock,
			}
		);

	useEffect( () => {
		setIsPlaceholder( ! src || src === '' );
	}, [ src ] );

	return (
		<PlayerWrapper>
			<LottieControls
				attributes={ attributes }
				className={ className }
				clientId={ clientId }
				context={ context }
				isSelected={ false }
				setAttributes={ setAttributes }
			/>
			<div
				{ ...blockProps }
				className={ classNames(
					{ 'is-placeholder': isPlaceholder },
					blockProps.className
				) }
				style={ { ...style, ...blockProps.style } }
			>
				<ResizableCover
					className={ 'block-library-lottiecover__resize-container' }
					fullscreen={ fullscreen }
					onResize={ ( value: number ) => {
						setAttributes( { height: value } );
					} }
					onResizeStart={ () => {
						setAttributes( { heightUnit: 'px' } );
						if ( toggleSelection ) {
							toggleSelection( false );
						}
					} }
					onResizeStop={ ( value: number ) => {
						setAttributes( { height: value } );
						if ( toggleSelection ) {
							toggleSelection( true );
						}
					} }
					showHandle={ isSelected }
				/>
				<span
					aria-hidden="true"
					className={ `wp-block-gb-lottiecover__background` }
					hidden={ isPlaceholder }
					style={ { backgroundColor: background } }
				/>
				{ isUploadingMedia && <Spinner /> }
				<Placeholder
					attributes={ attributes }
					className={ className }
					clientId={ clientId }
					context={ context }
					isSelected={ isSelected }
					setAttributes={ setAttributes }
				/>
				<ContextMenu
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
				{ ! isPlaceholder && <div { ...innerBlocksProps } /> }
			</div>
		</PlayerWrapper>
	);
}
