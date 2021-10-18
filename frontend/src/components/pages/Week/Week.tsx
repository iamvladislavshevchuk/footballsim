import { useMemo, useState } from "react"
import { unstable_batchedUpdates } from "react-dom"
import GameController from "../../../api/GameController"
import SimulationController from "../../../api/SimulationController"
import { useAppContext } from "../../../contexts/AppContext"
import groupBy from "../../../helpers/groupBy"
import useStatic from "../../../hooks/useStatic"
import useTitle from "../../../hooks/useTitle"
import Button from "../../blocks/Button/Button"
import Actions from "./components/Actions"
import Leaderboard from "./components/Leaderboard"
import Prediction from "./components/Prediction"
import Score from "./components/Score"
import './Week.scss'

export default function Week() {
    const { simulation, setSimulation } = useAppContext<Contexts.App.Stateful>()
    const [week, setWeek] = useState(simulation.week || 1)
    const games = useGamesByWeek(simulation.games, week)
    
    useTitle("Simulation: Week #" + week)

    const playWeek = async () => {
        const response = await SimulationController.week(simulation.id, simulation.week + 1)

        unstable_batchedUpdates(() => {
            setSimulation(response)
            setWeek(response.week)
        })
    }

    const playSeason = useStatic(async () => {
        const response = await SimulationController.season(simulation.id)

        unstable_batchedUpdates(() => {
            setSimulation(response)
            setWeek(simulation.last_week)
        })
    })

    const restart = useStatic(async () => {
        await SimulationController.destroy(simulation.id)
        setSimulation(undefined)
    })

    const previousWeek = useStatic(() => {
        setWeek(old => old - 1)
    })

    const nextWeek = useStatic(() => {
        setWeek(old => old + 1)
    })

    const handleScoreChange = async (score: string, position: "home_score" | "away_score", game: Resources.Game) => {
        const response = await GameController.update(game.id, { [position]: score || 0 })

        setSimulation(old => {
            if (!old) return

            const games = old.games.map(game => {
                if (game.id === response.id)
                    return response
                
                return game
            })

            return { ...old, games }
        })
    }

    return (
        <div className="Week">
            <div className="heading">
                <Button tertiary disabled={week === 1} onClick={previousWeek}>Previous</Button>
                <div className="middle">
                    <h3>Week #{week}</h3>
                    <small>{getWeekType(simulation.week, week)}</small>
                </div>
                <Button tertiary onClick={nextWeek} disabled={week === simulation.last_week}>Next</Button>
            </div>
            <div className="games">
                {games.map(game => (
                    <div key={game.id} className="game">
                        <div className="team-home">
                            <h3>{game.home.name}</h3>
                            <small>Home</small>
                        </div>
                        <Score game={game} onChange={handleScoreChange} />
                        <div className="team-away">
                            <h3>{game.away.name}</h3>
                            <small>Away</small>
                        </div>
                    </div>
                ))}
            </div>
            <Actions simulation={simulation} restart={restart} playSeason={playSeason} playWeek={playWeek} />
            <Leaderboard simulation={simulation} week={week} />
            <Prediction simulation={simulation} />
        </div>
    )
}

function getWeekType(current: number, actual: number) {
    if (actual > current)
        return "Future"
    else if (actual === current)
        return "Current"
    else 
        return "Past"
}

function useGamesByWeek(games: Resources.Game[], week: number) {
    return useMemo(() => groupBy(games, "week")[week], [games, week])
}