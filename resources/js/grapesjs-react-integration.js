// resources/js/grapesjs-react-integration.js
import React from 'react';
import ReactDOM from 'react-dom/client';
import GrapesJSDemo from './pages/GrapesJSDemo';

// Function to initialize the GrapesJS-React integration
function initGrapesJSReactIntegration() {
  // Create a container element if one doesn't exist
  let container = document.getElementById('grapesjs-react-container');
  
  if (!container) {
    container = document.createElement('div');
    container.id = 'grapesjs-react-container';
    container.style.width = '100%';
    container.style.height = '100vh';
    document.body.appendChild(container);
  }

  // Render the React component
  const root = ReactDOM.createRoot(container);
  root.render(<GrapesJSDemo />);
}

// Check if the DOM is already loaded, otherwise wait for it
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initGrapesJSReactIntegration);
} else {
  initGrapesJSReactIntegration();
}

// Export for potential use in other modules
export { initGrapesJSReactIntegration };