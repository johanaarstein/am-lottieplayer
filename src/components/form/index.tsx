import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '@utils';

import type { KeyboardEvent, ReactNode } from 'react';

const SwitchLabel = ( {
	className = '',
	id = '',
	onChange,
	subTitle,
	title,
	value,
	disabled,
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
			id={ id }
			help={ subTitle }
			className={ `lottie-switch-label ${ className }` }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<FormToggle
				checked={ value }
				onChange={ () => onChange( ! value ) }
				disabled={ disabled }
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
	id = '',
	onChange,
	title,
	value = '',
	disabled,
	placeholder = '',
}: NumberInputProps ) => {
	const keydownHandler = ( e: KeyboardEvent< HTMLInputElement > ) => {
		if ( isModifierKey( e ) ) return;
		if ( ! isNumericInput( e ) ) {
			e.preventDefault();
		}
	};

	return (
		<BaseControl
			id={ id }
			help={ title }
			className={ 'lottie-number-wrapper' }
		>
			<TextControl
				value={ value }
				onChange={ ( n ) => {
					onChange(
						n === undefined || n === '' ? undefined : Number( n )
					);
				} }
				onKeyDown={ keydownHandler }
				disabled={ disabled }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

const TextInput = ( {
	id = '',
	onChange,
	title,
	help,
	value = '',
	placeholder = '',
	disabled,
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
			id={ id }
			help={ help }
			className={ 'lottie-number-wrapper' }
		>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<TextControl
				value={ value }
				disabled={ disabled }
				onChange={ ( n ) => onChange( n ) }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

export { NumberInput, SwitchLabel, TextInput };
