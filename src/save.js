/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param  root0
 * @param  root0.attributes
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save( { attributes } ) {
	const { content, option, url } = attributes;
	return (
		<div
			{ ...useBlockProps.save() }
			style={ { display: 'flex', clear: 'both' } }
		>
			<a
				href={ url }
				data-option={ option }
				className="btn cta-btn react-link aligncenter read-more"
			>
				{ content }
			</a>
		</div>
	);
}
