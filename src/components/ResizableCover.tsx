import classnames from 'classnames';

import { useState } from '@wordpress/element';
import { ResizableBox } from '@wordpress/components';

import type { ResizableCoverProps } from '@types';

export default function ResizableCover( {
	children,
	className,
	fullscreen,
	onResizeStart,
	onResize,
	onResizeStop,
	showHandle,
	...rest
}: ResizableCoverProps ) {
	const [ isResizing, setIsResizing ] = useState( false );

	return (
		<ResizableBox
			className={ classnames( className, { 'is-resizing': isResizing } ) }
			enable={ {
				bottom: ! fullscreen,
			} }
			minHeight={ 10 }
			onResizeStart={ onResizeStart }
			onResize={ ( _e, _dir, el ) => {
				onResize( el.clientHeight );
				if ( ! isResizing ) {
					setIsResizing( true );
				}
			} }
			onResizeStop={ ( _e, _dir, el ) => {
				onResizeStop( el.clientHeight );
				setIsResizing( false );
			} }
			showHandle={ showHandle }
			{ ...rest }
		>
			{ children }
		</ResizableBox>
	);
}
