import type { DependencyList, EffectCallback } from 'react'

import { useEffect, useRef } from '@wordpress/element'

export default function useComponentDidUpdate(effect: EffectCallback, deps: DependencyList) {
  const initialRenderRef = useRef(true)

  useEffect(() => {
    if (initialRenderRef.current) {
      initialRenderRef.current = false

      return
    }
    effect()
  }, deps)
}