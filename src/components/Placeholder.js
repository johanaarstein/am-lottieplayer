import { useEffect, useRef } from '@wordpress/element';
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
		alt,
		autoplay,
		controls,
		direction,
		id,
		loop,
		mode,
		objectFit,
		speed,
		src,
	} = attributes;

	const player = useRef( null );

	useEffect( () => {
		if ( player.current ) {
			if ( controls ) {
				player.current.setAttribute( 'controls', true );
			} else {
				player.current.removeAttribute( 'controls' );
			}
			if ( loop ) {
				player.current.setAttribute( 'loop', true );
			} else {
				player.current.removeAttribute( 'loop' );
			}
			if ( autoplay ) {
				player.current.setAttribute( 'autoplay', true );
			} else {
				player.current.removeAttribute( 'autoplay' );
			}
		}
	}, [ autoplay, controls, loop ] );

	return (
		<div className="w-full" { ...useBlockProps() }>
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
				<div id={ `lottie-wrapper-${ id }` }>
					<dotlottie-player
						description={ alt }
						direction={ direction }
						mode={ mode }
						preserveAspectRatio={ aspectRatio( objectFit ) }
						ref={ player }
						speed={ speed }
						src={ src }
					/>
				</div>
			) }
		</div>
	);
}
