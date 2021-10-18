import axios from "axios";

export default class GameController {
    static async update(gameId: string | number, data: UpdateData) {
        const result = await axios.patch<Resources.Game>(`/games/${gameId}`, data)
        return result.data
    }
}

interface UpdateData {
    home_score?: number
    away_score?: number
}