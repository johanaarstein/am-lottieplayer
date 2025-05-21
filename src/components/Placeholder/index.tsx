import type { BlockEditProps } from '@wordpress/blocks'

import { useEffect, useState } from '@wordpress/element'

import type { PlayerComponentProps } from '@/types'

import PlayerComponent from '@/components/Placeholder/PlayerComponent'
import UploadComponent from '@/components/Placeholder/UploadComponent'

export default function Placeholder( {
  attributes,
  clientId,
  setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
  const [ state, setState ] = useState( { isPlaceholder: true } )

  useEffect( () => {
    setState( ( prev ) => ( {
      ...prev,
      isPlaceholder: ! attributes.src || attributes.src === '',
    } ) )
  }, [ attributes.src ] )

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
