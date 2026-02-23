import { BaseControl, FormToggle } from '@wordpress/components'

interface SwitchProps {
  disabled?: boolean
  id: string;
  onChange: (x: boolean) => unknown;
  subTitle?: string;
  title?: string;
  value?: boolean;
}

export default function SwitchLabel({
  disabled,
  id,
  onChange,
  subTitle,
  title,
  value = false,
}: SwitchProps) {
  return (
    <BaseControl
      className={'lottie-switch-label'}
      help={subTitle}
      id={id}
    >
      <BaseControl.VisualLabel>{title}</BaseControl.VisualLabel>
      <FormToggle
        disabled={disabled}
        checked={value}
        onChange={() => onChange(!value)}
      />
    </BaseControl>
  )
}