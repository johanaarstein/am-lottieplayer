import {
	DropZone,
	DropZoneProvider,
	ResizableBox,
} from '@wordpress/components';
import { BlockEdit, useBlockProps } from '@wordpress/block-editor';

import Placeholder from '../components/Placeholder';

import './editor.scss';

export default function Edit( {
	attributes = {},
	clientId = '',
	setAttributes = () => {},
	isSelected = false,
	toggleSelection = () => {},
} = {} ) {
	const { content, minHeight, src } = attributes;

	return (
		<>
			<div
				{ ...useBlockProps() }
				// className={ `wp-lottiecover wp-block${
				// 	align !== 'none' ? ' align' + align : ''
				// }${ isSelected ? ' is-selected' : '' }` }
				style={ { minHeight } }
			>
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
					<BlockEdit
						attributes={ { content } }
						clientId={ clientId }
						isSelected={ isSelected }
						setAttributes={ setAttributes }
					/>
				) }
			</div>
		</>
	);
}
