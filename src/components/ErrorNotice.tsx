import { Notice } from '@wordpress/components'

export default function ErrorNotice (message: string) {
  return (
    <Notice className="am-lottieplayer-notice" status="error">
      {message}
    </Notice>
  )
}