// resources/js/components/GrapesJSReact.js
import React, { useEffect, useRef } from 'react';

const GrapesJSReact = ({ 
  initialContent = '<div class="container">Start building your page here</div>', 
  onContentChange = () => {},
  plugins = [],
  pluginOptions = {},
  height = '500px',
  width = '100%'
}) => {
  const editorRef = useRef(null);
  const containerRef = useRef(null);

  useEffect(() => {
    // Dynamically load GrapesJS if not already loaded
    const loadGrapesJS = async () => {
      if (typeof window.grapesjs !== 'undefined') {
        initEditor();
        return;
      }

      // Load GrapesJS CSS
      const cssLink = document.createElement('link');
      cssLink.rel = 'stylesheet';
      cssLink.href = 'https://unpkg.com/grapesjs/dist/css/grapes.min.css';
      document.head.appendChild(cssLink);

      // Load GrapesJS
      const script = document.createElement('script');
      script.src = 'https://unpkg.com/grapesjs';
      script.async = true;
      
      script.onload = () => {
        // Load additional plugins if specified
        if (plugins.length > 0) {
          loadPlugins(plugins).then(() => {
            initEditor();
          });
        } else {
          initEditor();
        }
      };
      
      document.head.appendChild(script);
    };

    const loadPlugins = (pluginList) => {
      return Promise.all(
        pluginList.map(plugin => {
          return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = `https://unpkg.com/${plugin}`;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
          });
        })
      );
    };

    const initEditor = () => {
      if (!editorRef.current && containerRef.current) {
        const editor = window.grapesjs.init({
          container: containerRef.current,
          height: height,
          width: width,
          fromElement: true, // Use the initial content provided
          storageManager: { autoload: false },
          plugins: plugins,
          pluginsOpts: pluginOptions,
          components: initialContent,
          style: `* { margin: 0; padding: 0; box-sizing: border-box; } body { font-family: Arial, sans-serif; }`
        });

        // Listen for content changes
        editor.on('component:content', () => {
          onContentChange(editor.getHtml(), editor.getCss(), editor.getProjectData());
        });

        editor.on('component:style', () => {
          onContentChange(editor.getHtml(), editor.getCss(), editor.getProjectData());
        });

        // Store editor reference
        editorRef.current = editor;
      }
    };

    // Cleanup function
    return () => {
      if (editorRef.current) {
        editorRef.current.destroy();
        editorRef.current = null;
      }
    };
  }, [initialContent, plugins, pluginOptions, height, width, onContentChange]);

  return (
    <div 
      ref={containerRef} 
      style={{ 
        height: height, 
        width: width,
        border: '1px solid #ccc',
        borderRadius: '4px',
        overflow: 'hidden'
      }}
    />
  );
};

export default GrapesJSReact;