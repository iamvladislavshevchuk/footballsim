import { BrowserRouter, Switch, Route } from 'react-router-dom'
import Week from '../components/pages/Week/Week'
import Welcome from '../components/pages/Welcome/Welcome'
import WithoutSimulationMiddleware from './middleware/WithoutSimulationMiddleware'
import WithSimulationMiddleware from './middleware/WithSimulationMiddleware'

export default function Routes() {
    return (
        <BrowserRouter>
            <Switch>
                <Route exact path="/">
                    <WithoutSimulationMiddleware>
                        <Welcome />
                    </WithoutSimulationMiddleware>
                </Route>
                <Route exact path="/simulation">
                    <WithSimulationMiddleware>
                        <Week />
                    </WithSimulationMiddleware>
                </Route>
            </Switch>
        </BrowserRouter>
    )
}