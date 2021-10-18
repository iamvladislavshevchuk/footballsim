import axios from "axios";

export default class SimulationStatisticsController {
    static async show(simulationId: number | string, week: number) {
        const result = await axios.get<Responses.Statistics>(`/simulations/${simulationId}/statistics`, { params: { week }})
        return result.data
    }
}