import Button from "../../../blocks/Button/Button"

export default function Actions({ simulation, restart, playSeason, playWeek }: Props) {
    if (simulation.finished) 
        return (
            <div className="actions">
                <div />
                <Button onClick={restart}>Restart</Button>
            </div>
        )
    
    return (
        <div className="actions">
            <Button secondary onClick={restart}>Restart</Button>
            <div className="actions__right">
                <Button onClick={playSeason} secondary>Play Season</Button>
                <Button onClick={playWeek}>Play Week #{simulation.week + 1}</Button>
            </div>
        </div>
    )
    
}

interface Props {
    simulation: Resources.Simulation
    restart: () => Promise<void>
    playSeason: () => Promise<void>
    playWeek: () => Promise<void>
}