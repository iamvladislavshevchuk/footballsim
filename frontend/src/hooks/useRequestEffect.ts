import React, { DependencyList, useState } from "react"
import { unstable_batchedUpdates } from "react-dom"
import useAsyncEffect from "./useAsyncEffect"

/**
 * Runs the request on effect. Returns the state.
 */
export default function useRequestEffect<T>(
    request: () => Promise<T>, 
    options?: Options
): [T | undefined, React.Dispatch<React.SetStateAction<T | undefined>>, Status] {
    const [status, setStatus] = useState<Status>("processing")
    const [data, setData] = useState<T>()

    useAsyncEffect(async () => {
        const data = await request()
            .catch(e => undefined)

        unstable_batchedUpdates(() => {
            setData(data)
            setStatus("completed")
        })
    }, options?.deps || [])

    return [data, setData, status]
}

interface Options {
    deps?: DependencyList
    cache?: string
}

type Status = "processing" | "completed"