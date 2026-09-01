import type { ResizeStartCallback } from 're-resizable'

import { ResizableBox } from '@wordpress/components'
import { useState } from '@wordpress/element'
import classnames from 'classnames'

interface Props {
  fullscreen?: boolean
  onResize: (n: number) => void
  onResizeStart: ResizeStartCallback
  onResizeStop: (n: number) => void
  showHandle?: boolean
}

export default function ResizableCover( {
  children,
  className,
  fullscreen,
  onResize,
  onResizeStart,
  onResizeStop,
  showHandle,
  ...rest
}: React.HTMLAttributes<HTMLElement> & Props) {
  const [ isResizing, setIsResizing ] = useState( false )

  return (
    <ResizableBox
      className={ classnames( className, { 'is-resizing': isResizing } ) }
      enable={ { bottom: ! fullscreen } }
      minHeight={ 10 }
      showHandle={ showHandle }
      onResizeStart={ onResizeStart }
      onResize={ (
        _e, _dir, el
      ) => {
        onResize( el.clientHeight )
        if ( ! isResizing ) {
          setIsResizing( true )
        }
      } }
      onResizeStop={ (
        _e, _dir, el
      ) => {
        onResizeStop( el.clientHeight )
        setIsResizing( false )
      } }
      { ...rest }
    >
      { children }
    </ResizableBox>
  )
}
