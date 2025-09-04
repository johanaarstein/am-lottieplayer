import { speak } from '@wordpress/a11y'
import {
  // @ts-expect-error
  __experimentalLinkControl as LinkControl,
  BlockIcon,
  MediaUpload as MediaUploadComponent,
  MediaUploadCheck,
} from '@wordpress/block-editor'
import {
  Dropdown,
  FormFileUpload,
  MenuItem,
  NavigableMenu,
  ToolbarButton,
} from '@wordpress/components'
import { useSelect } from '@wordpress/data'
import { __unstableStripHTML as stripHTML } from '@wordpress/dom'
import {
  useEffect, useRef, useState
} from '@wordpress/element'
import { __ } from '@wordpress/i18n'
import { upload } from '@wordpress/icons'
import classNames from 'classnames'

import type { PlayerComponentProps } from '@/types'

import Lottie from '@/assets/Lottie'
import ErrorNotice from '@/components/ErrorNotice'
import { isValidUrl } from '@/utils'

type MediaUpload = (options: {
  allowedTypes: string[];
  filesList: FileList | null;
  onFileChange: (media: Media[]) => void;
  onError: (message: string) => void;
}) => void

export interface Media {
  alt?: string;
  id: number;
  url?: string;
};

const domain = 'am-lottieplayer'

const onUploadError = (message: string) => {
  const safeMessage: string = stripHTML(message)

  // We need to set a timeout for showing the notice
  // so that VoiceOver and possibly other screen readers
  // can announce the error afer the toolbar button
  // regains focus once the upload dialog closes.
  // Otherwise VO simply skips over the notice and announces
  // the focused element and the open menu.
  setTimeout(() => {
    ErrorNotice(safeMessage)
  }, 1000)
}

export default function MediaReplace({
  attributes,
  setAttributes,
}: {
  readonly attributes: PlayerComponentProps;
  readonly setAttributes: (attrs: Partial<PlayerComponentProps>) => void;
}) {
  const [state, setState] = useState({
    externalURL: attributes.src || '',
    mediaId: Number(attributes.id),
  }),
    editMediaButtonRef = useRef<HTMLButtonElement>(null),
    mediaUpload: MediaUpload | undefined = useSelect((select) => {
      try {
        const { getSettings }: { getSettings: () => { mediaUpload: MediaUpload } } =
          select('core/block-editor')

        return getSettings().mediaUpload
      } catch (error) {
        console.error(error)
      }
    }, []),
    allowedTypes = ['application/json', 'application/zip'],
    accept = '.lottie,.json',
    onSelectMedia = (media: Media) => {
      try {
        if (!media.url) {
          setAttributes({
            id: undefined,
            src: undefined
          })

          return
        }
        setState((prev) => ({
          ...prev,
          mediaId: media.id
        }))
        setAttributes({
          alt: media.alt,
          id: media.id.toString(),
          src: media.url,
        })
      } catch (error) {
        ErrorNotice(__('There was an error uploading your file', domain))
      }
    },
    selectMedia = (media: Media, closeMenu: () => void) => {
      closeMenu()
      // Calling `onSelect` after the state update since it might unmount the component.
      onSelectMedia(media)
      speak(__('The media file has been replaced'))
    },
    uploadFiles = ({ target }: React.ChangeEvent<HTMLInputElement>,
      closeMenu: () => void) => {
      try {
        if (!mediaUpload) {
          throw new Error('Media Upload function is not set')
        }
        const { files } = target

        mediaUpload({
          allowedTypes,
          filesList: files,
          onError: onUploadError,
          onFileChange: ([media]) => {
            selectMedia(media, closeMenu)
          },
        })
      } catch (error) {
        console.error(error)
      }
    },
    openOnArrowDown = (e:
      | React.KeyboardEvent<HTMLAnchorElement>
      | React.KeyboardEvent<HTMLButtonElement>) => {
      if (e.key !== 'ArrowDown') {
        return
      }
      e.preventDefault()
      if (
        e.target instanceof HTMLAnchorElement ||
        e.target instanceof HTMLButtonElement
      ) {
        e.target.click()
      }
    }

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
    <Dropdown
      contentClassName="block-editor-media-replace-flow__options"
      renderContent={({ onClose }) =>
        <>
          <NavigableMenu className="block-editor-media-replace-flow__media-upload-menu">
            <MediaUploadCheck>
              <MediaUploadComponent
                allowedTypes={allowedTypes}
                multiple={false}
                value={state.mediaId}
                render={({ open }) =>
                  <MenuItem
                    icon={<BlockIcon icon={Lottie} />}
                    onClick={open}
                  >
                    {__('Open Media Library')}
                  </MenuItem>
                }
                onSelect={(media) => {
                  selectMedia(media, onClose)
                }
                }
              />
              <FormFileUpload
                accept={accept}
                render={({ openFileDialog }) => {
                  return (
                    <MenuItem
                      icon={upload}
                      onClick={() => {
                        openFileDialog()
                      }}
                    >
                      {__('Upload')}
                    </MenuItem>
                  )
                }}
                onChange={(event) => {
                  uploadFiles(event, onClose)
                }}
              />
            </MediaUploadCheck>
          </NavigableMenu>
          <form
            className={classNames('block-editor-media-flow__url-input',
              { 'has-siblings': Boolean(mediaUpload) })}
          >
            <span className="block-editor-media-replace-flow__image-url-label">
              {__('Current media URL:')}
            </span>

            <LinkControl
              settings={[]}
              showSuggestions={false}
              value={{ url: attributes.src }}
              onChange={(externalURL: string) => {
                setState((prev) => ({
                  ...prev,
                  externalURL,
                }))
                editMediaButtonRef.current?.focus()
              }}
            />
          </form>
        </>
      }
      renderToggle={({ isOpen, onToggle }) =>
        <ToolbarButton
          aria-expanded={isOpen}
          aria-haspopup="true"
          ref={editMediaButtonRef}
          onClick={onToggle}
          onKeyDown={openOnArrowDown}
        >
          {__('Replace')}
        </ToolbarButton>
      }
    />
  )
}
