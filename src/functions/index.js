const attributesFromMedia = ( setAttributes, dimRatio ) => {
		return ( media ) => {
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
	debounce = ( callBack, timeout = 100 ) => {
		let timer;

		return ( ...args ) => {
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
	isTouch = () => {
		return window && 'ontouchstart' in window;
	},
	mediaPosition = ( { x = 0.5, y = 0.5 } ) => {
		return `${ Math.round( x * 100 ) }% ${ Math.round( y * 100 ) }%`;
	};

export {
	attributesFromMedia,
	debounce,
	isModifierKey,
	isNumericInput,
	isTouch,
	mediaPosition,
};
