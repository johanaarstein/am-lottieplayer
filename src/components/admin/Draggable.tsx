import {
	Children,
	cloneElement,
	isValidElement,
	useCallback,
	useEffect,
	useState,
} from '@wordpress/element';

import { arrayMove } from '@utils';

import type { Dispatch, ReactElement, ReactNode, SetStateAction } from 'react';
import type { Attachment } from '@types';

interface ParentState {
	isDragging: string | null;
	isEntered: string | null;
	prevIndex: number;
}

export function Draggable( {
	children,
	className = '',
}: {
	children: ReactNode;
	className?: string;
} ) {
	const [ parentState, setParentState ] = useState< ParentState >( {
			isDragging: null,
			isEntered: null,
			prevIndex: 0,
		} ),
		childrenWithProps = Children.map( children, ( child ) => {
			if ( isValidElement( child ) ) {
				return cloneElement( child as ReactElement, {
					parentState,
					setParentState,
				} );
			}
			return child;
		} );
	return (
		<div
			className={ className }
			onDragOver={ ( e ) => {
				e.preventDefault();
			} }
		>
			{ childrenWithProps }
		</div>
	);
}

export function DraggableItem( {
	children,
	className = '',
	list,
	setList,
	id: idFromProps,
	parentState,
	setParentState,
}: {
	children: ReactNode;
	className?: string;
	id: number;
	list: Attachment[];
	setList: Dispatch< SetStateAction< Attachment[] > >;
	parentState?: ParentState;
	setParentState?: Dispatch< SetStateAction< ParentState > >;
} ) {
	const [ dragState, setDragState ] = useState( {
			isDragging: false,
			x: 0,
			y: 0,
		} ),
		[ axis, setAxis ] = useState( 'X' ),
		resize = useCallback(
			( { matches }: MediaQueryList | MediaQueryListEvent ) => {
				if ( matches ) {
					setAxis( 'Y' );
				} else {
					setAxis( 'X' );
				}
			},
			[]
		),
		prevIndex = list.findIndex( ( { id } ) => id === idFromProps );

	useEffect( () => {
		const mediaQueryList = window.matchMedia( '(max-width: 760px)' );
		resize( mediaQueryList );
		mediaQueryList.addEventListener( 'change', resize );
		return () => {
			mediaQueryList.removeEventListener( 'change', resize );
		};
	}, [ resize ] );

	return (
		<div
			id={ idFromProps.toString() }
			className={ `am-dragitem ${ className }` }
			draggable
			style={
				parentState?.isEntered === idFromProps.toString()
					? {
							transform: `translate${ axis }(calc(${ -(
								prevIndex - parentState.prevIndex
							) }00% + ${ -(
								prevIndex - parentState.prevIndex
							) }em))`,
					  }
					: undefined
			}
			data-drag={ dragState.isDragging }
			data-enter={ parentState?.isEntered === idFromProps.toString() }
			onDragStart={ ( { currentTarget: { id: isDragging } } ) => {
				if ( setParentState ) {
					setParentState( ( prev ) => ( {
						...prev,
						isDragging,
						prevIndex,
					} ) );
				}
				setDragState( ( prev ) => ( { ...prev, isDragging: true } ) );
			} }
			onDragEnter={ ( { currentTarget: { id: isEntered } } ) => {
				if ( setParentState ) {
					setParentState( ( prev ) => ( { ...prev, isEntered } ) );
				}
			} }
			onDragEnd={ () => {
				if ( parentState?.isEntered ) {
					const newIndex = list.findIndex(
						( { id } ) => id.toString() === parentState.isEntered
					);
					setList( ( prev ) =>
						arrayMove( [ ...prev ], prevIndex, newIndex )
					);
				}
				setDragState( { isDragging: false, x: 0, y: 0 } );
				if ( setParentState ) {
					setParentState( {
						isEntered: null,
						isDragging: null,
						prevIndex: 0,
					} );
				}
			} }
		>
			{ children }
		</div>
	);
}
