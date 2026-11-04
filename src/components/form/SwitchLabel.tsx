import { BaseControl } from '@wordpress/components'
import { Switch } from '@wordpress/ui'

interface SwitchProps {
  disabled?: boolean
  id: string
  onChange: (x: boolean) => unknown
  subTitle?: string
  title?: React.ReactNode
  value?: boolean
}

export default function SwitchLabel({
  disabled,
  id,
  onChange,
  subTitle,
  title,
  value = false,
}: Readonly<SwitchProps>) {
  return (
    <BaseControl className={'lottie-switch-label'} help={subTitle} id={id}>
      <BaseControl.VisualLabel>{title}</BaseControl.VisualLabel>
      <Switch
        disabled={disabled}
        checked={value}
        onCheckedChange={() => onChange(!value)}
      />
    </BaseControl>
  )
}
