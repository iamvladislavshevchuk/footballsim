import { DependencyList, useEffect } from "react"

/**
 * Similar hook to useEffect, but it only runs async effects.
 */
export default function useAsyncEffect(effect: AsyncEffectCallback, deps: DependencyList = []): void {
    useEffect(() => {
        effect()
    }, deps)
}

type AsyncEffectCallback = () => Promise<void>