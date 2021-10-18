import React, { createContext, useContext } from "react"

const AppContext = createContext<Context | null>(null)

const useAppContext = <T extends Context = Context>() => {
    const data = useContext(AppContext)
    if (!data) throw "Context is missing. Check if you use the context in in the right context."
    return data as T
}

export default AppContext
export { useAppContext }

interface Context {
    simulation: Resources.Simulation | undefined
    setSimulation: React.Dispatch<React.SetStateAction<Resources.Simulation | undefined>>
}