import {
  BlockIcon,
  MediaPlaceholder,
  MediaUploadCheck,
  URLInput,
} from '@wordpress/block-editor'
import { useState } from '@wordpress/element'
import { __ } from '@wordpress/i18n'

import type { LottieBlockAttributes } from '@/types'

import Lottie from '@/assets/Lottie'
import ErrorNotice from '@/components/ErrorNotice'
import { validateUrl } from '@/utils'

const domain = 'am-lottieplayer'

export default function UploadComponent({
  attributes,
  setAttributes,
}: LottieBlockAttributes) {
  const [externalURL, setExternalURL] = useState(() => {
    if (validateUrl(attributes.src)) {
      setAttributes?.({ src: attributes.src })

      return attributes.src
    }

    return ''
  })

  return (
    <MediaUploadCheck>
      <MediaPlaceholder
        accept={'.lottie, .json'}
        allowedTypes={['application/json', 'application/zip']}
        icon={<BlockIcon icon={Lottie} />}
        labels={{
          instructions: __('Add Lottie animations from your Media Library to your WordPress post.', domain),
          title: __('AM Lottie Animation', domain),
        }}
        onError={(message) => {
          ErrorNotice(message)
        }}
        onSelect={(props) => {
          try {
            if (!props.url) {
              setAttributes?.({
                id: undefined,
                src: undefined
              })

              return
            }
            setAttributes?.({
              alt: props.alt,
              id: props.id.toString(),
              src: props.url,
            })
          } catch (error) {
            console.error(error)
            ErrorNotice(__('Failed to upload Lottie'))
          }
        }}
      >
        {
          (
            <URLInput
              className="lottie-animation-url"
              value={externalURL}
              onChange={(url) => {
                setExternalURL(url)

                if (validateUrl(url)) {
                  setAttributes?.({ src: url })
                }
              }
              }
            />
          ) as unknown as undefined
        }
      </MediaPlaceholder>
    </MediaUploadCheck>
  )
}
