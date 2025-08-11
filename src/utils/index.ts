import type { KeyboardEvent } from 'react'

const untrailingslashit = (str: string): string => {
  if (str.endsWith('/')) {
    return untrailingslashit(str.slice(0, Math.max(0, str.length - 1)))
  }

  return str
}

export const debounce = ( callBack: ( x: unknown ) => unknown, timeout = 100 ) => {
    let timer: ReturnType< typeof setTimeout >

    return ( ...args: unknown[] ) => {
      clearTimeout( timer )
      timer = setTimeout( () => {
        callBack( [ ...args ] )
      }, timeout )
    }
  },
  isModifierKey = ( {
    ctrlKey, key, metaKey, shiftKey
  }: KeyboardEvent ) =>
    shiftKey ||
    key === 'End' ||
    key === 'Home' ||
    key === 'Backspace' ||
    key === 'Tab' ||
    key === 'Enter' ||
    key === 'Delete' ||
    ( ctrlKey || metaKey ) &&
    ( key === 'a' ||
      key === 'c' ||
      key === 'v' ||
      key === 'x' ||
      key === 'z' ||
      key === 't' ||
      key === 'r' ),
  isNumericInput = ( { key }: KeyboardEvent ) =>
    Number( key ) >= 0 && Number( key ) <= 9,
  isTouch = () => 'ontouchstart' in window,
  isValidUrl = (url: string) => {
    const urlPattern = /^(?:https?:\/\/)?(?:[a-z0-9-]+\.)+[a-z]{2,}(?:\/\S*)?$/i

    return urlPattern.test(url)
  },
  mediaPosition = ( { x = 0.5, y = 0.5 } ) =>
    `${ Math.round( x * 100 ) }% ${ Math.round( y * 100 ) }%`,
  trailingslashit = ( str: string ) => {
    return `${ untrailingslashit( str ) }/`
  }
