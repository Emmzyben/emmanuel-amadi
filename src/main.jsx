import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'

// Import slick css
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

// We don't import index.css because styles are in /public/css/style.css loaded in index.html

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
)
