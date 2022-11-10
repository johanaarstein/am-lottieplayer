import { useCallback, useEffect, useRef } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { Lottie } from '../assets/icons';
import Upload from './Upload';

import { aspectRatio } from '../functions';

export default function Placeholder( {
	attributes = {},
	className = '',
	setAttributes = () => {},
} = {} ) {
	const {
		align,
		alt,
		autoplay,
		background,
		controls,
		direction,
		height,
		loop,
		mode,
		objectFit,
		renderer,
		speed,
		src,
		width,
	} = attributes;

	const player = useRef( null ),
		initialRender = useRef( true ),
		reloadPlayer = useCallback( () => {
			player.current.reload();
			setTimeout( () => {
				const canvas =
					player?.current?.shadowRoot?.querySelector( 'canvas' );
				// eslint-disable-next-line no-unused-expressions
				renderer === 'svg' && canvas && canvas.remove();
			}, 100 );
		}, [ renderer ] ),
		parseWidth = useCallback(
			( num ) => {
				if ( align === 'wide' || align === 'full' ) return '100%';
				if ( num && typeof num === 'number' ) return `${ num }px`;
				return null;
			},
			[ align ]
		);

	useEffect( () => {
		if ( ! initialRender.current ) {
			reloadPlayer();
		}
		initialRender.current = false;
	}, [ objectFit, reloadPlayer, renderer, speed ] );

	useEffect( () => {
		if (
			player.current &&
			loop &&
			autoplay &&
			player.current.currentState !== 'playing'
		) {
			player.current.play();
		}
	}, [ autoplay, loop ] );

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
					className={ className }
					style={ {
						width: parseWidth( width ),
						height:
							height && typeof height === 'number'
								? `${ height }px`
								: null,
						backgroundColor: background,
					} }
				>
					<dotlottie-player
						autoplay={ autoplay ? '' : null }
						controls={ controls ? '' : null }
						description={ alt }
						direction={ direction }
						loop={ loop ? '' : null }
						mode={ mode }
						preserveAspectRatio={ aspectRatio( objectFit ) }
						ref={ player }
						renderer={ renderer }
						speed={ speed }
						src={ src }
					/>
				</div>
			) }
		</div>
	);
}
