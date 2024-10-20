import type { ResizableCoverProps } from '@/types';

import { ResizableBox } from '@wordpress/components';
import { useState } from '@wordpress/element';
import classnames from 'classnames';

export default function ResizableCover( {
	children,
	className,
	fullscreen,
	onResize,
	onResizeStart,
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
			onResize={ ( _e, _dir, el ) => {
				onResize( el.clientHeight );
				if ( ! isResizing ) {
					setIsResizing( true );
				}
			} }
			onResizeStart={ onResizeStart }
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
