declare module Contexts {
    interface App {
        simulation: Resources.Simulation | undefined
        setSimulation: React.Dispatch<React.SetStateAction<Resources.Simulation | undefined>>
    }

    module App {
        interface Stateful extends App {
            simulation: Resources.Simulation
            setSimulation: React.Dispatch<React.SetStateAction<Resources.Simulation | undefined>>    
        }
    }
}