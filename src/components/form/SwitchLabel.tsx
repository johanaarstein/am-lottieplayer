import { BaseControl, FormToggle } from '@wordpress/components'

export default function SwitchLabel({
  disabled,
  id = '',
  onChange,
  subTitle,
  title,
  value = false,
}: {
  id: string;
  onChange: (x: boolean) => unknown;
  subTitle?: string;
  title?: React.ReactNode;
  value?: boolean;
  disabled?: boolean;
}) {
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