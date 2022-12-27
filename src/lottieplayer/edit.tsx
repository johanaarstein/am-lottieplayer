import React from 'react';
import { useEffect, useRef } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';

import LottieControls from '../components/LottieControls';
import Placeholder from '../components/Placeholder';

import './editor.scss';

import { EditProps } from '../global.d';

export default function Edit( { attributes, setAttributes }: EditProps ) {
	const { src } = attributes,
		isPlaceholder = useRef( true );

	useEffect( () => {
		isPlaceholder.current = ! src || src === '';
	}, [ src ] );

	return (
		<>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div { ...useBlockProps() }>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
					isPlaceholder={ isPlaceholder.current }
				/>
			</div>
		</>
	);
}