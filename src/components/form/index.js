import { FormToggle, PanelRow } from '@wordpress/components';

import styles from './form.scss';

export const InputLabel = ( {
	className = '',
	disabled = false,
	id = '',
	label = '',
	onChange = () => {},
	placeholder = '',
	type = '',
	value = '',
	...rest
} = {} ) => {
	return (
		<div className={ `${ className } ${ styles.inputControl }` }>
			<label className={ styles.label } htmlFor={ id }>
				{ label }
			</label>
			<input
				id={ id }
				className={ styles.input }
				type={ type }
				placeholder={ placeholder }
				value={ value }
				disabled={ disabled }
				onChange={ ( event ) => onChange( event.target.value ) }
				{ ...rest }
			/>
		</div>
	);
};

export const SwitchLabel = ( {
	onChange = () => {},
	subTitle = '',
	title = '',
	id = '',
	value = false,
} = {} ) => {
	return (
		<PanelRow>
			<label className={ styles.label } htmlFor={ id }>
				{ title }
				<div>{ subTitle }</div>
			</label>
			<FormToggle
				id={ id }
				checked={ value }
				onChange={ () => onChange( ! value ) }
			/>
		</PanelRow>
	);
};
