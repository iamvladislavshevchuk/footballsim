declare module Resources {
    interface Team {
        id: number
        name: string
        strength: number
    }

    interface Game {
        id: number
        home: Team
        away: Team
        home_score: number | null
        away_score: number | null
        week: number
    }

    interface Simulation {
        id: number
        week: number
        games: Game[]
        finished: boolean
        last_week: number
    }
}