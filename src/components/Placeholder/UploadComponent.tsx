import {
  BlockIcon,
  MediaPlaceholder,
  MediaUploadCheck,
  URLInput,
} from '@wordpress/block-editor'
import { useEffect, useState } from '@wordpress/element'
import { __ } from '@wordpress/i18n'

import type { PlayerComponentProps } from '@/types'

import Lottie from '@/assets/Lottie'
import ErrorNotice from '@/components/ErrorNotice'
import { isValidUrl } from '@/utils'

const domain = 'am-lottieplayer'

export default function UploadComponent({
  attributes,
  setAttributes,
}: {
  readonly attributes: PlayerComponentProps;
  readonly setAttributes: (attrs: Partial<PlayerComponentProps>) => void;
}) {
  const [state, setState] = useState({
    externalURL: attributes.src || '',
    hasDropped: false,
  })

  useEffect(() => {
    if (
      isValidUrl(state.externalURL) &&
      (state.externalURL.endsWith('.lottie') ||
        state.externalURL.endsWith('.json'))
    ) {
      // eslint-disable-next-line react-you-might-not-need-an-effect/you-might-not-need-an-effect
      setAttributes({ src: state.externalURL })
    }
  }, [state.externalURL, setAttributes])

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
              setAttributes({
                id: undefined,
                src: undefined
              })

              return
            }
            setAttributes({
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
              }
              }
            />
          ) as unknown as undefined
        }
      </MediaPlaceholder>
    </MediaUploadCheck>
  )
}
