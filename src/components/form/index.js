// import { useCallback, useEffect } from '@wordpress/element';
import { BaseControl, FormToggle, TextControl } from '@wordpress/components';

import { isModifierKey, isNumericInput } from '../../functions';

const SwitchLabel = ( {
	onChange = () => {},
	subTitle = '',
	title = '',
	value = false,
} = {} ) => {
	return (
		<BaseControl help={ subTitle } className={ 'lottie-switch-label' }>
			<BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
			<FormToggle
				checked={ value }
				onChange={ () => onChange( ! value ) }
			/>
		</BaseControl>
	);
};

const NumberInput = ( {
	onChange = () => {},
	title = '',
	value = null,
	disabled = false,
	placeholder = '',
} = {} ) => {
	const keydownHandler = ( e ) => {
		if ( isModifierKey( e ) ) return;
		// eslint-disable-next-line no-unused-expressions
		! isNumericInput( e ) && e.preventDefault();
	};

	return (
		<BaseControl help={ title } className={ 'lottie-number-wrapper' }>
			<TextControl
				value={ value }
				onChange={ ( n ) => onChange( Number( n ) ) }
				onKeyDown={ keydownHandler }
				disabled={ disabled }
				placeholder={ placeholder }
			/>
		</BaseControl>
	);
};

export { NumberInput, SwitchLabel };
