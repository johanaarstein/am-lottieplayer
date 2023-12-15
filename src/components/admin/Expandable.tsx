import { useCallback, useEffect, useRef } from '@wordpress/element';

import type { ReactNode } from 'react';

export default function Expandable( {
	children,
	className = '',
	trigger,
}: {
	children: ReactNode;
	className?: string;
	trigger?: unknown;
} ) {
	const container = useRef< HTMLDivElement >( null ),
		inner = useRef< HTMLDivElement >( null ),
		getHeight = useCallback( () => {
			const { current: elOuter } = container,
				{ current: elInner } = inner;
			if ( elInner && elOuter ) {
				elOuter.style.maxHeight = `${ elInner.offsetHeight }px`;
				elOuter.style.minHeight = `${ elInner.offsetHeight }px`;
			}
		}, [] );

	useEffect( () => {
		getHeight();
	}, [ trigger, getHeight ] );
	return (
		<div className={ `${ className } am-expandable` } ref={ container }>
			<div ref={ inner }>{ children }</div>
		</div>
	);
}
