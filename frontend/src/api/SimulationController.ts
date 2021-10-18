import axios from "axios";

export default class SimulationController {
    static async show() {
        const result = await axios.get<Resources.Simulation>("/simulations")
        return result.data
    }

    static async store() {
        const result = await axios.post<Resources.Simulation>("/simulations")
        return result.data
    }

    static async week(simulationId: number | string, week: number) {
        const result = await axios.patch<Resources.Simulation>(`/simulations/${simulationId}/week`, { week })
        return result.data
    }

    static async season(simulationId: number | string) {
        const result = await axios.patch<Resources.Simulation>(`/simulations/${simulationId}/season`)
        return result.data
    }

    static async destroy(simulationId: number | string) {
        const result = await axios.delete<Resources.Simulation>(`/simulations/${simulationId}`)
        return result.data
    }
}