import { BlockIcon, MediaPlaceholder } from '@wordpress/block-editor';
import { useCallback, useEffect, useRef } from '@wordpress/element';
import { useDispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';
import { __ } from '@wordpress/i18n';

import { Lottie } from '../assets/icons';

import { aspectRatio, attributesFromMedia } from '../functions';

export default function Placeholder( {
	attributes = {},
	setAttributes = () => {},
	isPlaceholder = true,
} = {} ) {
	const { createErrorNotice } = useDispatch( noticesStore ),
		onUploadError = ( message ) => {
			createErrorNotice( message, { type: 'snackbar' } );
		},
		onSelectMedia = attributesFromMedia( setAttributes );

	return (
		<>
			{ isPlaceholder ? (
				<UploadComponent
					onSelectMedia={ onSelectMedia }
					onError={ onUploadError }
				/>
			) : (
				<PlayerComponent attributes={ attributes } />
			) }
		</>
	);
}

const UploadComponent = ( {
	children,
	onSelectMedia = () => {},
	onError = () => {},
} = {} ) => {
	return (
		<MediaPlaceholder
			icon={ <BlockIcon icon={ Lottie } /> }
			labels={ {
				title: __( 'Lottie Animation' ),
				instructions: __(
					'Upload Lottie animations to WordPress and add them in Gutenberg.'
				),
			} }
			onSelect={ onSelectMedia }
			accept={ '.lottie, application/json, application/zip, text/plain' }
			allowedTypes={ [
				'application/json',
				'application/zip',
				'text/plain',
			] }
			onError={ onError }
		>
			{ children }
		</MediaPlaceholder>
	);
};

// const UploadComponent = ( { setAttributes = () => {} } ) => {
// 	return (
// 		<div className={ `components-placeholder` }>
// 			<div className="components-placeholder__label">
// 				<Lottie /> { __( 'Lottie Animation' ) }
// 			</div>
// 			<div className="components-placeholder__instructions">
// 				{ __(
// 					'Upload Lottie animations to WordPress and add them in Gutenberg.'
// 				) }
// 			</div>
// 			<div className="components-placeholder__fieldset">
// 				<form>
// 					<Upload
// 						onSelect={ ( newSrc ) =>
// 							setAttributes( { src: newSrc } )
// 						}
// 						render={ ( { open } ) => (
// 							<Button variant="primary" onClick={ open }>
// 								{ __( 'Media Library' ) }
// 							</Button>
// 						) }
// 					/>
// 				</form>
// 			</div>
// 		</div>
// 	);
// };

const PlayerComponent = ( { attributes = {} } = {} ) => {
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
		} = attributes,
		player = useRef( null ),
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
		<dotlottie-player
			class="lottie-element"
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
			style={ {
				width: parseWidth( width ),
				height:
					height && typeof height === 'number'
						? `${ height }px`
						: null,
				backgroundColor: background,
			} }
		/>
	);
};

export { PlayerComponent, UploadComponent };
