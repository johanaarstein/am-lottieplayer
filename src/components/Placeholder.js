import { useCallback, useEffect, useRef } from '@wordpress/element';
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
		// align,
		alt,
		autoplay,
		controls,
		direction,
		height,
		id,
		loop,
		mode,
		objectFit,
		speed,
		src,
		width,
	} = attributes;

	const player = useRef( null ),
		objectFitSVG = useCallback( () => {
			player?.current?.shadowRoot
				?.querySelector( 'svg' )
				?.setAttribute(
					'preserveAspectRatio',
					aspectRatio( objectFit )
				);
		}, [ aspectRatio, objectFit ] );

	// const fixSize = useCallback( () => {
	// 	const { offsetHeight, offsetWidth } = player.current;
	// 	if ( ! width && align !== 'full' ) {
	// 		setAttributes( { width: offsetWidth } );
	// 	}
	// 	if ( ! height ) {
	// 		setAttributes( { height: offsetHeight } );
	// 	}
	// }, [ align, height, width ] );

	// useEffect( () => {
	// 	player?.current?.addEventListener( 'rendered', fixSize, false );

	// 	return () =>
	// 		player?.current?.removeEventListener( 'rendered', fixSize, false );
	// }, [ fixSize ] );

	useEffect( () => {
		objectFitSVG();
	}, [ objectFit, objectFitSVG ] );

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
									<Button variant="primary" onClick={ open }>
										{ __( 'Media Library' ) }
									</Button>
								) }
							/>
						</form>
					</div>
				</div>
			) : (
				<div
					id={ `lottie-wrapper-${ id }` }
					style={ {
						width:
							width && typeof width === 'number'
								? `${ width }px`
								: null,
						height:
							height && typeof height === 'number'
								? `${ height }px`
								: null,
					} }
				>
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
