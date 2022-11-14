import {
	RichText,
	useBlockProps,
	useInnerBlocksProps,
	useSetting,
} from '@wordpress/block-editor';
import { DropZone, ResizableBox } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';
import { __ } from '@wordpress/i18n';

import './editor.scss';

export default function Edit( {
	attributes = {},
	isSelected = false,
	setAttributes = () => {},
	toggleSelection = () => {},
} = {} ) {
	const { allowedBlocks, background, height, heightUnit, src, templateLock } =
			attributes,
		{ createErrorNotice } = useDispatch( noticesStore ),
		getInnerBlocksTemplate = ( attr ) => {
			return [
				[
					'core/paragraph',
					{
						align: 'center',
						placeholder: __( 'Write title…' ),
						...attr,
					},
				],
			];
		},
		hasFontSizes = !! useSetting( 'typography.fontSizes' )?.length,
		innerBlocksTemplate = getInnerBlocksTemplate( {
			fontSize: hasFontSizes ? 'large' : undefined,
		} ),
		innerBlocksProps = useInnerBlocksProps(
			{
				className: 'wp-block-cover__inner-container',
			},
			{
				template: ! hasInnerBlocks ? innerBlocksTemplate : undefined,
				templateInsertUpdatesSelection: true,
				allowedBlocks,
				templateLock,
			}
		),
		onUploadError = ( message ) => {
			createErrorNotice( message, { type: 'snackbar' } );
		},
		handleDrop = ( e ) => {
			console.log( e );
		},
		heightWithUnit =
			height && heightUnit ? `${ height }${ heightUnit }` : height,
		style = {
			minHeight: heightWithUnit || undefined,
		};

	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div { ...useBlockProps() } style={ style }>
				<ResizableBox
					// size={ { height } }
					enable={ {
						top: false,
						right: false,
						bottom: true,
						left: false,
						topRight: false,
						bottomRight: false,
						bottomLeft: false,
						topLeft: false,
					} }
					minHeight={ 10 }
					onResizeStop={ ( event, direction, elt, delta ) => {
						setAttributes( {
							height: parseInt( height + delta.height, 10 ),
						} );
						toggleSelection( true );
					} }
					onResizeStart={ () => {
						toggleSelection( false );
					} }
					showHandle={ isSelected }
				/>
				<span
					aria-hidden="true"
					className={ `background` }
					style={ { backgroundColor: background } }
					hidden={ src === '' || ! src }
				/>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
				/>
				{ src === '' || ! src ? (
					''
				) : (
					<>
						<DropZone
							onFilesDrop={ handleDrop }
							onHTMLDrop={ handleDrop }
							onDrop={ handleDrop }
						/>
						<DropZone
							onFilesDrop={ handleDrop }
							onHTMLDrop={ handleDrop }
							onDrop={ handleDrop }
							className="wp-block-gb-lottiecover__inner-container"
						>
							{ /* <div className="wp-block-gb-lottiecover__inner-container"> */ }
							<RichText
								tagName="p"
								placeholder={ __( 'Write title' ) }
							/>
							{ /* </div> */ }
						</DropZone>
					</>
				) }
			</div>
		</>
	);
}
