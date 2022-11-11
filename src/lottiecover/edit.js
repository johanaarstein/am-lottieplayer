import {
	DropZone,
	DropZoneProvider,
	ResizableBox,
} from '@wordpress/components';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';

import './editor.scss';

export default function Edit( {
	attributes = {},
	setAttributes = () => {},
	toggleSelection = () => {},
} = {} ) {
	const { minHeight, src } = attributes;

	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div { ...useBlockProps() } style={ { minHeight } }>
				<ResizableBox
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
					minHeight={ minHeight }
					onResizeStop={ ( event, direction, elt, { height } ) => {
						setAttributes( {
							minHeight: parseInt( minHeight + height, 10 ),
						} );
						toggleSelection( true );
					} }
					onResizeStart={ () => {
						toggleSelection( false );
					} }
				/>
				<Placeholder
					attributes={ attributes }
					className={ 'lottie-background' }
					setAttributes={ setAttributes }
				/>
				<DropZoneProvider>
					<DropZone />
				</DropZoneProvider>
				{ src === '' || ! src ? (
					''
				) : (
					<InnerBlocks
						allowedBlocks={ [ 'core/image', 'core/paragraph' ] }
					/>
				) }
			</div>
		</>
	);
}
