import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '@functions';

import type { KeyboardEvent } from 'react';

type SwitchLabelProps = {
	id: string;
	onChange: ( x: boolean ) => void;
	subTitle?: string;
	title?: string;
	value?: boolean;
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
	onChange: ( x: number ) => void;
	title?: string;
	value?: string | number;
	disabled?: boolean;
	placeholder?: string;
};

const NumberInput = ( {
	id = '',
	onChange,
	title,
	value = '',
	disabled,
	placeholder = '',
}: NumberInputProps ) => {
	const keydownHandler = ( e: KeyboardEvent< HTMLInputElement > ) => {
		// console.log(e);
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
				value={ value }
				onChange={ ( n ) => onChange( +n ) }
				onKeyDown={ keydownHandler }
				disabled={ disabled }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

type TextInputProps = {
	help?: string;
	id?: string;
	onChange: ( x: string ) => void;
	title?: string;
	value?: string;
	placeholder?: string;
};

const TextInput = ( {
	id = '',
	onChange,
	title,
	help,
	value = '',
	placeholder = '',
}: TextInputProps ) => {
	return (
		<BaseControl
			id={ id }
			help={ help }
			className={ 'lottie-number-wrapper' }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<TextControl
				value={ value }
				onChange={ ( n ) => onChange( n ) }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

export { NumberInput, SwitchLabel, TextInput };
