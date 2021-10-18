import axios from 'axios'

export default class DefaultTeamController {
    static async index() {
        const result = await axios.get<Resources.Team[]>('/teams/default')
        return result.data
    }
}