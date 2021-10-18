import { useRef } from "react"

export default function useStatic<T>(value: T): T {
    const ref = useRef(value)
    return ref.current
}