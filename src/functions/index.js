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

export { aspectRatio, debounce, isModifierKey, isNumericInput };
