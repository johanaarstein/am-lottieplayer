import React, { KeyboardEvent, KeyboardEventHandler } from 'react';
import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '../../functions';

type SwitchLabelProps = {
	id: string;
	onChange: ( value: boolean ) => void;
	subTitle?: string;
	title?: string;
	value: boolean;
};

const SwitchLabel = ( {
	id = '',
	onChange,
	subTitle,
	title,
	value,
}: SwitchLabelProps ) => {
	return (
		<BaseControl
			id={ id }
			help={ subTitle }
			className={ 'lottie-switch-label' }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<FormToggle
				checked={ value }
				onChange={ () => onChange( ! value ) }
			/>
		</BaseControl>
	);
};

type NumberInputProps = {
	id: string;
	onChange: ( value: number ) => void;
	title?: string;
	value: number | null;
	disabled?: boolean;
	placeholder?: string;
};

const NumberInput = ( {
	id = '',
	onChange,
	title,
	value = null,
	disabled,
	placeholder = '',
}: NumberInputProps ) => {
	const keydownHandler: KeyboardEventHandler = (
		e: KeyboardEvent< HTMLInputElement >
	) => {
		if ( isModifierKey( e ) ) return;
		// eslint-disable-next-line no-unused-expressions
		! isNumericInput( e ) && e.preventDefault();
	};

	return (
		<BaseControl
			id={ id }
			help={ title }
			className={ 'lottie-number-wrapper' }
		>
			<TextControl
				value={ value as number }
				onChange={ ( n ) => onChange( +n ) }
				onKeyDown={ keydownHandler }
				disabled={ disabled }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

export { NumberInput, SwitchLabel };
