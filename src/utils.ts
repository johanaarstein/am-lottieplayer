import { isBlobURL } from '@wordpress/blob';

import type DotLottiePlayer from '@aarsteinmedia/dotlottie-player-light';
import type { AnimationDirection } from 'lottie-web';
import type { KeyboardEvent } from 'react';

export enum Align {
	Center = 'center',
	Full = 'full',
	Left = 'left',
	None = 'none',
	Right = 'right',
	Wide = 'wide',
}

export enum PlayMode {
	Bounce = 'bounce',
	Normal = 'normal',
}

export enum OnMouseOut {
	Void = 'void',
	Stop = 'stop',
	Pause = 'pause',
	Reverse = 'reverse',
}

export const arrayMove = < T >(
		arr: T[],
		prevIndex: number,
		newIndex: number
	) => {
		// if ( newIndex >= arr.length ) {
		// 	let k = newIndex - arr.length + 1;
		// 	while ( k-- ) {
		// 		arr.push( undefined );
		// 	}
		// }
		arr.splice( newIndex, 0, arr.splice( prevIndex, 1 )[ 0 ] );
		return arr;
	},
	attributesFromMedia =
		( setAttributes: ( attrs: object ) => void, dimRatio?: number ) =>
		( media: { url: string; id?: string; alt?: string } ) => {
			if ( ! media || ! media.url ) {
				setAttributes( { id: undefined, src: undefined } );
				return;
			}

			setAttributes( {
				alt: media?.alt,
				dimRatio: dimRatio === 100 ? 50 : dimRatio,
				id: media.id,
				src: media.url,
			} );
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
	formatBytes = ( bytes: number, decimals = 2 ) => {
		if ( ! +bytes ) {
			return '0 Bytes';
		}

		const k = 1024,
			dm = decimals < 0 ? 0 : decimals,
			sizes = [ 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ],
			i = Math.floor( Math.log( bytes ) / Math.log( k ) );

		return `${ parseFloat( ( bytes / Math.pow( k, i ) ).toFixed( dm ) ) } ${
			sizes[ i ]
		}`;
	},
	gcd = ( a: number, b: number ): number => ( b ? gcd( b, a % b ) : a ),
	getAspectRatio = ( width?: number, height?: number ): string | null => {
		if ( ! width || ! height ) {
			return null;
		}
		const divisor = gcd( width, height );
		return `${ width / divisor } / ${ height / divisor }`;
	},
	/**
	 * Get extension from filename, URL or path
	 * @param { string } str Filename, URL or path
	 */
	getExt = ( str: string ) => {
		if ( ! hasExt( str ) ) {
			return;
		}
		return str.split( '.' ).pop()?.toLowerCase();
	},
	/**
	 * Parse string to get filename without extension
	 * @param { string } src The url string
	 * @return { string } Filename
	 */
	getFilename = ( src: string ) =>
		`${ src.replace( /\.[^.]*$/, '' ).replace( /\W+/g, '' ) }`,
	hasExt = ( path: string ) => {
		const lastDotIndex = path.split( '/' ).pop()?.lastIndexOf( '.' );
		return (
			( lastDotIndex ?? 0 ) > 1 && path.length - 1 > ( lastDotIndex ?? 0 )
		);
	},
	injectStyle = ( style: string ) => {
		const styleElement = document.createElement( 'style' );
		let styleSheet: CSSStyleSheet | null = null;

		document.head.appendChild( styleElement );

		styleSheet = styleElement.sheet;

		styleSheet?.insertRule( style, styleSheet.cssRules.length );
	},
	isModifierKey = ( { ctrlKey, key, metaKey, shiftKey }: KeyboardEvent ) =>
		!! (
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
		),
	isNumericInput = ( { key }: KeyboardEvent< Element > ) =>
		Number( key ) >= 0 && Number( key ) <= 9,
	isTemporaryMedia = ( id?: string, url?: string ) =>
		! id && isBlobURL( url ),
	isTouch = () => window && 'ontouchstart' in window,
	isValidUrl = ( url: string ) => {
		const urlPattern = new RegExp(
			'^(https?:\\/\\/)?' + // validate protocol
				'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // validate domain name
				'((\\d{1,3}\\.){3}\\d{1,3}))' + // validate OR ip (v4) address
				'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // validate port and path
				'(\\?[;&a-z\\d%_.~+=-]*)?' + // validate query string
				'(\\#[-a-z\\d_]*)?$', // validate fragment locator
			'i'
		);
		return !! urlPattern.test( url );
	},
	mediaPosition = ( { x = 0.5, y = 0.5 } ) =>
		`${ Math.round( x * 100 ) }% ${ Math.round( y * 100 ) }%`,
	mouseOutHandler = (
		player: DotLottiePlayer,
		interaction: OnMouseOut,
		direction: AnimationDirection
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
				player?.setDirection(
					( direction * -1 ) as AnimationDirection
				);
				void player?.play();
				break;
			default:
				player?.stop();
		}
	},
	mouseOverHandler = ( player: DotLottiePlayer, direction: 1 | -1 ): void => {
		player?.setDirection( direction );
		void player?.play();
	},
	parseJsonFile = async < T >( file: File ): Promise< T > =>
		new Promise( ( resolve, reject ) => {
			const fileReader = new FileReader();
			fileReader.onload = ( { target } ) => {
				if ( target && typeof target.result === 'string' ) {
					// eslint-disable-next-line @typescript-eslint/no-unsafe-argument
					resolve( JSON.parse( target.result ) );
				}
			};
			fileReader.onerror = ( error ) => reject( error );
			fileReader.readAsText( file );
		} ),
	truncate = ( input: string, limit = 12 ) =>
		input.length > 12 ? `${ input.substring( 0, limit ) }… ` : input;
