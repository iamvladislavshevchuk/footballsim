import React from 'react'
import SimulationController from '../api/SimulationController'
import AppContext from '../contexts/AppContext'
import useRequestEffect from '../hooks/useRequestEffect'
import Routes from '../routes'
import './App.scss'

export default function App() {
  const [simulation, setSimulation, status] = useRequestEffect(SimulationController.show)

  if (status === "processing")
    return null
  
  return (
    <AppContext.Provider value={{ simulation, setSimulation }}>
      <div className="App">
        <Routes />
      </div>
    </AppContext.Provider>
  )
}