import { isBlobURL } from '@wordpress/blob';
import type { DotLottiePlayer } from '@johanaarstein/dotlottie-player';
import { OnMouseOut } from '../types';

const attributesFromMedia = (
		setAttributes: ( attrs: object ) => void,
		dimRatio?: number
	) => {
		return ( media: { url: string; id?: string; alt?: string } ) => {
			if ( ! media || ! media.url ) {
				setAttributes( { src: undefined, id: undefined } );
				return;
			}

			setAttributes( {
				dimRatio: dimRatio === 100 ? 50 : dimRatio,
				src: media.url,
				id: media.id,
				alt: media?.alt,
			} );
		};
	},
	debounce = ( callBack: ( x: unknown ) => unknown, timeout = 100 ) => {
		let timer: ReturnType< typeof setTimeout >;

		return ( ...args: unknown[] ) => {
			clearTimeout( timer );
			timer = setTimeout( () => {
				callBack( [ ...args ] );
			}, timeout );
		};
	},
	isModifierKey = ( { ctrlKey, key, metaKey, shiftKey } ) => {
		return (
			shiftKey ||
			key === 'End' ||
			key === 'Home' ||
			key === 'Backspace' ||
			key === 'Tab' ||
			key === 'Enter' ||
			key === 'Delete' ||
			( ( ctrlKey || metaKey ) &&
				( key === 'a' ||
					key === 'c' ||
					key === 'v' ||
					key === 'x' ||
					key === 'z' ||
					key === 't' ||
					key === 'r' ) )
		);
	},
	isNumericInput = ( { key } ) => {
		return key >= 0 && key <= 9;
	},
	isTemporaryMedia = ( id: string, url: string ) => ! id && isBlobURL( url ),
	isTouch = () => {
		return window && 'ontouchstart' in window;
	},
	mediaPosition = ( { x = 0.5, y = 0.5 } ) => {
		return `${ Math.round( x * 100 ) }% ${ Math.round( y * 100 ) }%`;
	},
	mouseOutHandler = (
		player: DotLottiePlayer,
		interaction: OnMouseOut,
		direction: 1 | -1
	): void => {
		switch ( interaction ) {
			case OnMouseOut.Void:
				break;
			case OnMouseOut.Stop:
				player?.stop();
				break;
			case OnMouseOut.Pause:
				player?.pause();
				break;
			case OnMouseOut.Reverse:
				player?.setDirection( direction * -1 );
				player?.play();
				break;
			default:
				player?.stop();
		}
	},
	mouseOverHandler = ( player: DotLottiePlayer, direction: 1 | -1 ): void => {
		player?.setDirection( direction );
		player?.play();
	};

export {
	attributesFromMedia,
	debounce,
	isModifierKey,
	isNumericInput,
	isTemporaryMedia,
	isTouch,
	mediaPosition,
	mouseOutHandler,
	mouseOverHandler,
};
