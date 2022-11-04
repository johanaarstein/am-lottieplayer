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
	};

export { aspectRatio, debounce };
