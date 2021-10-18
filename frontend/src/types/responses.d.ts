declare module Responses {
    type Statistics = {
        team: Resources.Team
        PTS: number
        P: number
        W: number
        D: number
        L: number
        GD: number
    }[]

    type Prediction = {
        team: Resources.Team
        chance: number
    }[]
}