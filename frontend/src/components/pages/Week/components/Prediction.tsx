import React, { useState } from 'react'
import SimulationPredictionController from '../../../../api/SimulationPredictionController'
import useAsyncEffect from '../../../../hooks/useAsyncEffect'

export default function Prediction({ simulation }: Props) {
    const prediction = usePrediction(simulation)

    if (simulation.week < 4 || simulation.week === simulation.last_week)
        return null

    return (
        <div className="prediction">
            <h3>Predictions</h3>
            <div className="prediction__teams">
                {prediction?.map(item => (
                    <div className="prediction__team" key={item.team.id}>
                        <h3>{item.team.name}</h3>
                        <small>{Math.round(item.chance * 100)}%</small>
                    </div>
                ))}
            </div>
        </div>
    )
}

function usePrediction(simulation: Resources.Simulation) {
    const [prediction, setPrediction] = useState<Responses.Prediction>()

    useAsyncEffect(async () => {
        if (simulation.week < 4 || simulation.week === simulation.last_week) 
            return

        SimulationPredictionController.show(simulation.id)
            .then(setPrediction)
    }, [simulation])

    return prediction
}

interface Props {
    simulation: Resources.Simulation
}