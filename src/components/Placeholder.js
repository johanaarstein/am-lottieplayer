import { useBlockProps } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import '@johanaarstein/dotlottie-player';

import { Lottie } from '../assets/icons';
import Upload from './Upload';

import { aspectRatio } from '../functions';

export default function Placeholder( {
	attributes = {},
	setAttributes = () => {},
} = {} ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		direction,
		id,
		loop,
		mode,
		objectFit,
		src,
	} = attributes;

	return (
		<div { ...useBlockProps() }>
			{ src === '' || ! src ? (
				<div className={ `components-placeholder` }>
					<div className="components-placeholder__label">
						<Lottie /> { __( 'Lottie Animation' ) }
					</div>
					<div className="components-placeholder__instructions">
						{ __(
							'Upload Lottie animations to WordPress and add them in Gutenberg.'
						) }
					</div>
					<div className="components-placeholder__fieldset">
						<form>
							<Upload
								onSelect={ ( newSrc ) =>
									setAttributes( { src: newSrc } )
								}
								render={ ( { open } ) => (
									<Button variant="link" onClick={ open }>
										{ __( 'Media Library' ) }
									</Button>
								) }
							/>
						</form>
					</div>
				</div>
			) : (
				<div
					className={ `components-placeholder wp-block` }
					data-align={ align }
					style={ { backgroundColor: background } }
				>
					<div
						className="w-full flex"
						id={ `lottie-wrapper-${ id }` }
					>
						<div className={ align }>
							<dotlottie-player
								autoplay={ autoplay }
								controls={ controls }
								description={ alt }
								direction={ direction }
								loop={ loop }
								mode={ mode }
								preserveAspectRatio={ aspectRatio( objectFit ) }
								src={ src }
							/>
						</div>
					</div>
				</div>
			) }
		</div>
	);
}
