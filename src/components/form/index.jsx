import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '../../functions';

const SwitchLabel = ( { id = '', onChange, subTitle, title, value } ) => {
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

const NumberInput = ( {
	id = '',
	onChange,
	title,
	value = '',
	disabled,
	placeholder = '',
} ) => {
	const keydownHandler = ( e ) => {
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

export { NumberInput, SwitchLabel };
