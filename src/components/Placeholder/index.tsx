import type { BlockEditProps } from '@wordpress/blocks'

import type { PlayerComponentProps } from '@/types'

import PlayerComponent from '@/components/Placeholder/PlayerComponent'
import UploadComponent from '@/components/Placeholder/UploadComponent'

export default function Placeholder({
  attributes,
  clientId,
  setAttributes,
}: Readonly<BlockEditProps<PlayerComponentProps>>) {

  return (
    <>
      {!attributes.src || attributes.src === '' ?
        <UploadComponent
          attributes={attributes}
          setAttributes={setAttributes}
        />
        :
        <PlayerComponent
          attributes={attributes}
          clientId={clientId}
        />
      }
    </>
  )
}
