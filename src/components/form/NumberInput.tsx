import { BaseControl, TextControl } from '@wordpress/components'

import { isModifierKey, isNumericInput } from '@/utils'

const keydownHandler = (e: React.KeyboardEvent<HTMLInputElement>) => {
  if (isModifierKey(e)) {
    return
  }
  if (!isNumericInput(e)) {
    e.preventDefault()
  }
}

export default function NumberInput({
  disabled,
  id = '',
  onChange,
  placeholder = '',
  title,
  value = '',
}: {
  disabled?: boolean;
  id: string;
  onChange: (x?: number) => void;
  placeholder?: string;
  title?: string;
  value?: string | number;
}) {
  return (
    <BaseControl
      className={'lottie-number-wrapper'}
      help={title}
      id={id}
    >
      <TextControl
        disabled={disabled}
        placeholder={placeholder}
        value={value}
        onKeyDown={keydownHandler}
        onChange={(n) => {
          onChange(n ? Number(n) : undefined)
        }}
      />
    </BaseControl>
  )
}