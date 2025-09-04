import type { DependencyList, EffectCallback } from 'react'

import { useEffect, useRef } from '@wordpress/element'

export default function useComponentDidUpdate(effect: EffectCallback, deps: DependencyList) {
  const initialRender = useRef(true)

  useEffect(() => {
    if (initialRender.current) {
      initialRender.current = false

      return
    }
    effect()
  }, deps)
}