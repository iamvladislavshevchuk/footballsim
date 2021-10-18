import React from 'react'
import ReactDOM from 'react-dom'
import './index.scss'
import "typeface-roboto"
import "./boot/axios"
import App from './components/App'

ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById('root')
)
