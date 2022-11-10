import { ResizableBox } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';

import Placeholder from '../components/Placeholder';

import './editor.scss';

export default function Edit( {
	attributes = {},
	setAttributes = () => {},
	isSelected = false,
	toggleSelection = () => {},
} = {} ) {
	const { align, minHeight } = attributes;

	return (
		<>
			<div
				{ ...useBlockProps() }
				className={ `wp-lottiecover wp-block${
					align !== 'none' ? ' align' + align : ''
				}${ isSelected ? ' is-selected' : '' }` }
			>
				<ResizableBox
					enable={{
						top: false,
						right: false,
						bottom: true,
						left: false,
						topRight: false,
						bottomRight: false,
						bottomLeft: false,
						topLeft: false,
					}}
					minHeight={minHeight}
					onResizeStop={(event, direction, elt, { /*delta.*/height }) => {
						setAttributes({
							minHeight: parseInt(minHeight + height, 10),
						});
						toggleSelection(true);
					}}
					onResizeStart={() => {
						toggleSelection(false);
					}}
				>
					<Placeholder
						attributes={attributes}
						setAttributes={setAttributes}
					/>
				</ResizableBox>
			</div>
		</>
	);
}
