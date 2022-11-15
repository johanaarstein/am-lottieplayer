import classnames from 'classnames';

import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

import Placeholder from '../components/Placeholder';

import './editor.scss';

export default function save( { attributes = {} } = {} ) {
	const { background, height, heightUnit, src, templateLock } = attributes,
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
				templateLock,
			}
		),
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: heightWithUnit || undefined,
		};

	return (
		<div
			{ ...blockProps }
			className={ classnames(
				isPlaceholder.current && 'is-placeholder',
				blockProps.className
			) }
			style={ { ...style, ...blockProps.style } }
		>
			<span
				aria-hidden="true"
				className={ `background` }
				style={ { backgroundColor: background } }
				hidden={ isPlaceholder.current }
			/>
			<Placeholder
				attributes={ attributes }
			/>
			{ ! isPlaceholder.current && <div { ...innerBlocksProps } /> }
		</div>
	);
}
