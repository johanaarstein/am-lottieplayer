/* eslint-disable @typescript-eslint/naming-convention */
import { useEffect, useRef } from '@wordpress/element'

export type EventHandler<E extends Event = Event> = (event: E) => void

const isRefObject = <T>(value: unknown): value is React.RefObject<T> => {
  return value !== null && typeof value === 'object' && 'current' in value
}

interface ElementOptions<T> {
  element?:
  | (Window & typeof globalThis)
  | React.RefObject<T>
  | Element
  | ScreenOrientation
  | Document
  | null
  | false
}

type EventOptions<T> = EventListenerOptions &
  AddEventListenerOptions & ElementOptions<T> & { enabled?: boolean }

/**
 * `useEventListener` is a custom React hook that adds an event listener to a specified element.
 * It simplifies the process of handling events by managing the event listener and callback function.
 *
 * @param eventType - The type of event to listen for.
 * @param callback - The function to execute when the event occurs.
 * @param options - The element to add the event listener to. Default is the window.
 */

export default function useEventListener<
  E extends Event = Event,
  T extends Element | null = Element,
>(
  eventType: string,
  callback: EventHandler<E>,
  options: EventOptions<T>
) {
  const {
    capture: isCapture, element: elementOptions, enabled: isEnabled = true, passive: isPassive
  } = options,

    element =
      elementOptions === undefined ? window : elementOptions,

    isElementRef = isRefObject(element),
    resolvedElement = isElementRef ? element.current : element,

    callbackRef = useRef(callback)

  useEffect(() => {
    callbackRef.current = callback
  }, [callback])

  useEffect(() => {
    if (!isEnabled) {
      return
    }

    let removeListener: (() => void) | undefined,
      cancelled = false,
      frameId = 0

    const attach = () => {
      const targetElement = isElementRef ? element.current : element

      if (!targetElement) {
        return false
      }

      const listenerOptions = {
        capture: isCapture,
        passive: isPassive
      },
        handler = ((e: E) => {
          callbackRef.current(e)
        }) as EventListener

        /* AnimationItem::addEventListener is not directly compatible
        with standard Element::addEventListener, but not in a way that
        will cause trouble */
        ; (targetElement as Window).addEventListener(
          eventType, handler, listenerOptions
        )

      removeListener = () => {
        ; (targetElement as Window).removeEventListener(
          eventType,
          handler,
          listenerOptions
        )
      }

      return true
    }

    if (!attach() && isElementRef) {
      const waitForElement = () => {
        if (cancelled) {
          return
        }
        if (attach()) {
          return
        }
        frameId = requestAnimationFrame(waitForElement)
      }

      frameId = requestAnimationFrame(waitForElement)
    }

    return () => {
      cancelled = true
      cancelAnimationFrame(frameId)
      removeListener?.()
    }
  }, [
    element,
    eventType,
    isCapture,
    isElementRef,
    isEnabled,
    isPassive,
    resolvedElement
  ])
}

export const WINDOW_LISTENER_OPTS = {
  capture: false,
  passive: true
} as const,
  SCROLL_LISTENER_OPTS = {
    capture: true,
    passive: true
  } as const