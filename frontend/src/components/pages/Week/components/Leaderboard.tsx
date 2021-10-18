import { useState } from "react"
import SimulationStatisticsController from "../../../../api/SimulationStatisticsController"
import useAsyncEffect from "../../../../hooks/useAsyncEffect"

export default function Leaderboard({ simulation, week }: Props) {
    const leaderboard = useLeaderboard(simulation, week)

    if (simulation.week === 0 || !leaderboard)
        return null

    return (
        <div className="results">
            <h3>{week === simulation.week ? "Results" : "Archive"} | Week #{week}</h3>
            <div className="table">
                <table>
                    <thead>
                        <th>Team</th>
                        <th title="Played">P</th>
                        <th title="Won">W</th>
                        <th title="Draws">D</th>
                        <th title="Lost">L</th>
                        <th title="Goal Difference">GD</th>
                        <th title="Points">PTS</th>
                    </thead>
                    <tbody>
                        {leaderboard.map(item => (
                            <tr key={item.team.id}>
                                <td>{item.team.name}</td>
                                <td>{item.P}</td>
                                <td>{item.W}</td>
                                <td>{item.D}</td>
                                <td>{item.L}</td>
                                <td>{item.GD}</td>
                                <td>{item.PTS}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    )
}

function useLeaderboard(simulation: Resources.Simulation, week: number) {
    const [leaderboard, setLeaderboard] = useState<Responses.Statistics>()

    useAsyncEffect(async () => {
        if (simulation.week < week)
            return

        SimulationStatisticsController.show(simulation.id, week)
            .then(setLeaderboard)
    }, [simulation, week])

    return leaderboard
}

interface Props {
    simulation: Resources.Simulation
    week: number
}