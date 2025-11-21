// resources/js/pages/GrapesJSDemo.js
import React, { useState } from 'react';
import GrapesJSReact from '../components/GrapesJSReact';

const GrapesJSDemo = () => {
  const [content, setContent] = useState('');
  const [css, setCss] = useState('');
  const [isSaved, setIsSaved] = useState(false);

  const handleContentChange = (html, css, projectData) => {
    setContent(html);
    setCss(css);
  };

  const handleSave = () => {
    // In a real application, you would send the content to your backend
    console.log('Saving content:', content);
    console.log('CSS:', css);
    
    // Simulate saving
    setIsSaved(true);
    setTimeout(() => setIsSaved(false), 3000);
  };

  return (
    <div className="grapesjs-demo">
      <div className="header">
        <h1>GrapesJS React Integration</h1>
        <button onClick={handleSave} className="save-button">
          {isSaved ? '✓ Saved!' : 'Save Page'}
        </button>
      </div>
      
      <div className="editor-container">
        <GrapesJSReact
          initialContent={`
            <div class="container mx-auto p-4">
              <h1 class="text-3xl font-bold text-blue-600 mb-4">Welcome to GrapesJS + React</h1>
              <p class="text-gray-600 mb-6">This is a React-integrated page builder with Tailwind CSS support.</p>
              <div class="bg-gray-100 p-6 rounded-lg">
                <h2 class="text-xl font-semibold mb-3">Edit this content</h2>
                <p class="text-gray-700">Drag and drop components to build your page.</p>
              </div>
            </div>
          `}
          onContentChange={handleContentChange}
          plugins={['gjs-blocks-basic']}
          pluginOptions={{
            'gjs-blocks-basic': {}
          }}
          height="600px"
        />
      </div>

      <div className="content-preview">
        <h2>Content Preview</h2>
        <div 
          className="preview-content"
          dangerouslySetInnerHTML={{ __html: content }}
        />
      </div>
    </div>
  );
};

export default GrapesJSDemo;