import React from 'react'
import { Redirect } from 'react-router'
import { useAppContext } from '../../contexts/AppContext'

export default function WithSimulationMiddleware({ children }: Props) {
    const { simulation } = useAppContext()

    if (! simulation)
        return <Redirect to="/" />

    return <>{children}</>
}

interface Props {
    children: React.ReactNode
}