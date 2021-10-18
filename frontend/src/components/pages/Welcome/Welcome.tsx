import { useHistory } from 'react-router'
import DefaultTeamController from '../../../api/DefaultTeamController'
import SimulationController from '../../../api/SimulationController'
import { useAppContext } from '../../../contexts/AppContext'
import useRequestEffect from '../../../hooks/useRequestEffect'
import useStatic from '../../../hooks/useStatic'
import useTitle from '../../../hooks/useTitle'
import Button from '../../blocks/Button/Button'
import './Welcome.scss'

export default function Welcome() {
    useTitle("Welcome!")
    const history = useHistory()
    const { setSimulation } = useAppContext()
    const [teams] = useRequestEffect(DefaultTeamController.index)

    const simulate = useStatic(async () => {
        const simulation = await SimulationController.store()
        setSimulation(simulation)
        history.push("/simulation")
    })

    if (!teams)
        return null

    return (
        <div className="welcome">
            <div className="heading">
                <h1>Welcome to Football Simulator!</h1>
                <p>It’s a simple website for test purposes, but it already has some fairly complex features. It was made by Vladislav Shevchuk and you can check the source code on Github. For now, you have only predefined teams. Strength was chosen randomly by the author.</p>
            </div>
            <div className="teams">
                {teams.map(team => (
                    <div key={team.id} className="team">
                        <h3>{team.name}</h3>
                        <small>Strength: {team.strength}</small>
                    </div>
                ))}
            </div>
            <div className="actions">
                <Button secondary href="https://github.com/iamvladislavshevchuk/footballsim" target="_blank">Github</Button>
                <Button onClick={simulate}>Start Simulation</Button>
            </div>
        </div>
    )
}