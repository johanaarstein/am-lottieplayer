import { useEffect } from '@wordpress/element'

export default function useComponentDidMount(effect: React.EffectCallback) {
  useEffect(() => {
    effect()
  }, [effect])
}