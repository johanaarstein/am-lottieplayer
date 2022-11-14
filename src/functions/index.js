const aspectRatio = ( objectFit ) => {
		switch ( objectFit ) {
			case 'contain' || 'scale-down':
				return 'xMidYMid meet';
			case 'cover':
				return 'xMidYMid slice';
			case 'fill':
				return 'none';
			case 'none':
				return 'xMinYMin slice';
			default:
				return 'xMidYMid meet';
		}
	},
	attributesFromMedia = ( setAttributes, dimRatio = null ) => {
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
				// focalPoint: undefined,
				// ...( mediaType === VIDEO_BACKGROUND_TYPE
				// 	? { hasParallax: undefined }
				// 	: {} ),
			} );
		};
	},
	debounce = ( func = () => {}, timeout = 100 ) => {
		let timer;

		return ( ...args ) => {
			clearTimeout( timer );
			timer = setTimeout( () => {
				func( ...args );
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
	};

export {
	aspectRatio,
	attributesFromMedia,
	debounce,
	isModifierKey,
	isNumericInput,
};
