import type React from 'react'

import { BaseControl, TextControl } from '@wordpress/components'

export default function TextInput( {
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
  onChange: (x: string) => void;
  placeholder?: string;
  title?: React.ReactNode;
  value?: null | string;
  disabled?: boolean
} ) {
  return (
    <BaseControl
      className={ 'lottie-number-wrapper' }
      help={ help }
      id={ id }
    >
      <BaseControl.VisualLabel>{ title }</BaseControl.VisualLabel>
      <TextControl
        placeholder={ placeholder }
        value={ value ?? '' }
        disabled={disabled}
        onChange={ ( n ) => { onChange( n ) } }
      />
    </BaseControl>
  )
}
