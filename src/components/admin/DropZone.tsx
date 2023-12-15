import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import type { DragEvent, DragEventHandler, ReactNode } from 'react';

export default function DropZone( {
	children,
	className = '',
	onDrop,
}: {
	children: ReactNode;
	className?: string;
	onDrop: DragEventHandler;
} ) {
	const [ hasDragOver, setHasDragOver ] = useState( false ),
		preventDefaults = ( e: DragEvent ) => {
			e.preventDefault();
			e.stopPropagation();
		};
	return (
		<div
			onDrag={ ( e ) => preventDefaults( e ) }
			onDragStart={ ( e ) => preventDefaults( e ) }
			onDragEnd={ ( e ) => preventDefaults( e ) }
			onDragOver={ ( e ) => preventDefaults( e ) }
			onDragEnter={ ( e ) => {
				preventDefaults( e );
				setHasDragOver( true );
			} }
			onDragLeave={ ( e ) => {
				preventDefaults( e );
				setHasDragOver( false );
			} }
			onDrop={ ( e ) => {
				preventDefaults( e );
				onDrop( e );
				setHasDragOver( false );
			} }
			className={ `${ className } am-dropzone` }
			data-hasDragOver={ hasDragOver }
		>
			<div className="am-dropzone-instructions">
				<span>
					{ __( "Drop it like it's hot!", 'am-lottieplayer' ) }
				</span>
			</div>
			{ children }
		</div>
	);
}
