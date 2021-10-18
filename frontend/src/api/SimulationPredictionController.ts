import axios from "axios";

export default class SimulationPredictionController {
    static async show(simulationId: number | string) {
        const result = await axios.get<Responses.Prediction>(`/simulations/${simulationId}/prediction`)
        return result.data
    }
}