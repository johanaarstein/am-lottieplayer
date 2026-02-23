import { isBlobURL } from '@wordpress/blob'

interface Media {
  alt?: string
  id?: string;
  url: string;
}

export const attributesFromMedia =
  (setAttributes: (attrs: object) => void, dimRatio?: number) =>
    (media: Media) => {
      if (!media.url) {
        setAttributes({
          id: undefined,
          src: undefined
        })

        return
      }

      setAttributes({
        alt: media.alt,
        dimRatio: dimRatio === 100 ? 50 : dimRatio,
        id: media.id,
        src: media.url,
      })
    },
  isTemporaryMedia = (id?: string, url?: string) =>
    !id && isBlobURL(url)