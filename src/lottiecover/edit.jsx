import { useEffect, useRef, useState } from '@wordpress/element';
import {
	store as blockEditorStore,
	useBlockProps,
	useInnerBlocksProps,
	useSetting,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import classnames from 'classnames';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';
import ResizableCover from '../components/ResizableCover';

import './editor.scss';

const getInnerBlocksTemplate = ( attributes ) => {
	return [
		[
			'core/paragraph',
			{
				align: 'center',
				placeholder: __( 'Write title…', 'am-lottieplayer' ),
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
} ) {
	const { allowedBlocks, background, height, heightUnit, src, templateLock } =
			attributes,
		ref = useRef(),
		[ isPlaceholder, setIsPlaceholder ] = useState( true ),
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
					hidden={ isPlaceholder }
				/>
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
