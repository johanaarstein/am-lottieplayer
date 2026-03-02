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
import { isValidUrl } from '@/utils'

const domain = 'am-lottieplayer',
  validateUrl = (url: unknown): url is string => {
    if (typeof url !== 'string') {
      throw new TypeError('Invalid URL')
    }

    if (!isValidUrl(url) || !url.endsWith('.lottie') && !url.endsWith('.json')) {
      throw new Error('Invalid URL')
    }

    return true
  }

export default function UploadComponent({
  attributes,
  setAttributes,
}: LottieBlockAttributes) {
  const [state, setState] = useState(() => {
    if (validateUrl(attributes.src)) {
      setAttributes?.({ src: attributes.src })

      return {
        externalURL: attributes.src,
        hasDropped: false
      }
    }

    return {
    externalURL: '',
    hasDropped: false,
  }
})

  return (
    <MediaUploadCheck>
      <MediaPlaceholder
        accept={'.lottie, .json'}
        allowedTypes={['application/json', 'application/zip']}
        icon={<BlockIcon icon={Lottie} />}
        labels={{
          instructions: state.hasDropped
            ? __('Dropped!', domain)
            : __('Add Lottie animations from your Media Library to your WordPress post.',
              domain),
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
        onHTMLDrop={() => {
          setState((prev) => ({
            ...prev,
            hasDropped: true
          }))
        }
        }
      >
        {
          (
            <URLInput
              value={state.externalURL}
              onChange={(externalURL) => {
                setState((prev) => ({
                  ...prev,
                  externalURL,
                }))

                if (validateUrl(externalURL)) {
                  setAttributes?.({ src: externalURL })
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
