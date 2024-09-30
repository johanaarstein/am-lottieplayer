import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '@utils';

import type { KeyboardEvent, ReactNode } from 'react';

const SwitchLabel = ( {
	className = '',
	disabled,
	id = '',
	onChange,
	subTitle,
	title,
	value,
}: {
	className?: string;
	id: string;
	onChange: ( x: boolean ) => void;
	subTitle?: ReactNode;
	title?: ReactNode;
	value?: boolean;
	disabled?: boolean;
} ) => {
	return (
		<BaseControl
			className={ `lottie-switch-label ${ className }` }
			help={ subTitle }
			id={ id }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<FormToggle
				checked={ value }
				disabled={ disabled }
				onChange={ () => onChange( ! value ) }
			/>
		</BaseControl>
	);
};

type NumberInputProps = {
	id: string;
	onChange: ( x?: number ) => void;
	title?: string;
	value?: string | number;
	disabled?: boolean;
	placeholder?: string;
};

const NumberInput = ( {
	disabled,
	id = '',
	onChange,
	placeholder = '',
	title,
	value = '',
}: NumberInputProps ) => {
	const keydownHandler = ( e: KeyboardEvent< HTMLInputElement > ) => {
		if ( isModifierKey( e ) ) {
			return;
		}
		if ( ! isNumericInput( e ) ) {
			e.preventDefault();
		}
	};

	return (
		<BaseControl
			className={ 'lottie-number-wrapper' }
			help={ title }
			id={ id }
		>
			<TextControl
				disabled={ disabled }
				onChange={ ( n ) => {
					onChange(
						n === undefined || n === '' ? undefined : Number( n )
					);
				} }
				onKeyDown={ keydownHandler }
				placeholder={ placeholder }
				value={ value }
			/>
		</BaseControl>
	);
};

const TextInput = ( {
	disabled,
	help,
	id = '',
	onChange,
	placeholder = '',
	title,
	value = '',
}: {
	help?: string;
	id?: string;
	onChange: ( x: string ) => void;
	title?: ReactNode;
	value?: string;
	placeholder?: string;
	disabled?: boolean;
} ) => {
	return (
		<BaseControl
			className={ 'lottie-number-wrapper' }
			help={ help }
			id={ id }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<TextControl
				disabled={ disabled }
				onChange={ ( n ) => onChange( n ) }
				placeholder={ placeholder }
				value={ value }
			/>
		</BaseControl>
	);
};

export { NumberInput, SwitchLabel, TextInput };
