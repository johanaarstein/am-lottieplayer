import type { BlockEditProps } from '@wordpress/blocks'

import { useState } from '@wordpress/element'

import type { PlayerComponentProps } from '@/types'

import PlayerComponent from '@/components/Placeholder/PlayerComponent'
import UploadComponent from '@/components/Placeholder/UploadComponent'
import useDidComponentUpdate from '@/hooks/useDidComponentUpdate'

export default function Placeholder( {
  attributes,
  clientId,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const [ state, setState ] = useState( { isPlaceholder: true } )

  useDidComponentUpdate(() => {
    setState(() => ({ isPlaceholder: !attributes.src || attributes.src === '' }))
  }, [attributes.src])

  return (
    <>
      { state.isPlaceholder ?
        <UploadComponent
          attributes={ attributes }
          setAttributes={ setAttributes }
        />
        :
        <PlayerComponent
          attributes={ attributes }
          clientId={ clientId }
        />
      }
    </>
  )
}
