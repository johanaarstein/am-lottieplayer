import classnames from 'classnames';

import { useState } from '@wordpress/element';
import { ResizableBox } from '@wordpress/components';

export default function ResizableCover( {
	className,
	onResizeStart,
	onResize,
	onResizeStop,
	showHandle,
	...rest
} ) {
	const [ isResizing, setIsResizing ] = useState( false );

	return (
		<ResizableBox
			className={ classnames( className, { 'is-resizing': isResizing } ) }
			enable={ {
				top: false,
				right: false,
				bottom: true,
				left: false,
				topRight: false,
				bottomRight: false,
				bottomLeft: false,
				topLeft: false,
			} }
			minHeight={ 10 }
			onResizeStart={ ( event, direction, elt ) => {
				onResizeStart( elt.clientHeight );
				onResize( elt.clientHeight );
			} }
			onResize={ ( event, direction, elt ) => {
				onResize( elt.clientHeight );
				if ( ! isResizing ) setIsResizing( true );
			} }
			onResizeStop={ ( event, direction, elt ) => {
				onResizeStop( elt.clientHeight );
				setIsResizing( false );
			} }
			showHandle={ showHandle }
			{ ...rest }
		/>
	);
}
