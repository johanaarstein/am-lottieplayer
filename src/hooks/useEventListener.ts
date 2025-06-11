/* eslint-disable fsecond/valid-event-listener */
import { useEffect, useRef } from '@wordpress/element'

export type EventHandler<E extends Event = Event> = (event: E) => void

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
  options: EventListenerOptions &
    AddEventListenerOptions & {
      element?:
      | (Window & typeof globalThis)
      | React.RefObject<T>
      | Element
      | ScreenOrientation
      | Document
      | null
      | false
    } = {}
) {
  if (!options.element) {
    options.element = window
  }

  const callbackRef = useRef(callback)

  useEffect(() => {
    callbackRef.current = callback
  }, [callback])

  useEffect(() => {
    const targetElement =
      options.element && 'current' in options.element
        ? options.element.current
        : options.element

    if (!targetElement) {
      return
    }

    const handler = (e: E) => {
      callbackRef.current(e)
    }

    // if (eventType === 'complete') {
    //   console.log(targetElement.addEventListener)
    // }


    targetElement.addEventListener(
      eventType, handler as EventListener, options
    )

    return () => {
      targetElement.removeEventListener(
        eventType,
        handler as EventListener,
        options.capture
      )
    }
  }, [eventType, options])
}
