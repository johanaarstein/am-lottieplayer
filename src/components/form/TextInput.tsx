import { BaseControl, TextControl } from '@wordpress/components'

interface Props {
  disabled?: boolean
  help?: string
  id?: string
  onChange: (x: string) => void
  placeholder?: string
  title?: React.ReactNode
  value?: null | string
}
export default function TextInput({
  disabled,
  help,
  id = '',
  onChange,
  placeholder = '',
  title,
  value = '',
}: Readonly<Props>) {
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
        onChange={ (n) => { onChange(n) } }
      />
    </BaseControl>
  )
}
