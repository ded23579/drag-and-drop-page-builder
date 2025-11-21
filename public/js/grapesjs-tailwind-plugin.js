// GrapesJS Tailwind Plugin
// This plugin integrates Tailwind CSS with GrapesJS

(window => {
  const load = (win) => {
    const grapesjs = win.grapesjs;
    const plugin = (editor, opts = {}) => {
      const options = {
        blocks: ['container', 'row', 'text', 'image', 'button'],
        ...opts
      };

      const bm = editor.BlockManager;

      // Add Tailwind-specific blocks
      if (options.blocks.includes('container')) {
        bm.add('container', {
          label: 'Container',
          content: '<div class="container mx-auto px-4">Container</div>',
          attributes: { class: 'gjs-fonts gjs-f-b1' }
        });
      }

      if (options.blocks.includes('row')) {
        bm.add('row', {
          label: 'Row',
          content: '<div class="flex flex-wrap -mx-4">Row</div>',
          attributes: { class: 'gjs-fonts gjs-f-row' }
        });
      }

      if (options.blocks.includes('text')) {
        bm.add('text', {
          label: 'Text',
          content: '<p class="text-gray-700">Text block</p>',
          attributes: { class: 'gjs-fonts gjs-f-text' }
        });
      }

      if (options.blocks.includes('image')) {
        bm.add('image', {
          label: 'Image',
          content: '<img class="w-full h-auto" src="https://via.placeholder.com/300x200" alt="Placeholder image">',
          attributes: { class: 'gjs-fonts gjs-f-image' }
        });
      }

      if (options.blocks.includes('button')) {
        bm.add('button', {
          label: 'Button',
          content: '<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Button</button>',
          attributes: { class: 'gjs-fonts gjs-f-button' }
        });
      }

      // Add Tailwind CSS support to style manager
      const sm = editor.StyleManager;
      
      // Add Tailwind-specific properties
      sm.addProperty('Tailwind', [
        {
          type: 'custom',
          property: 'tw-class',
          label: 'Tailwind Class',
          placeholder: 'e.g. bg-red-500, text-center, p-4',
        }
      ]);
    };

    // Load the plugin
    grapesjs.plugins.add('grapesjs-tailwind', plugin);
  };

  // Check if GrapesJS is already loaded
  if (window.grapesjs) {
    load(window);
  } else {
    // Load GrapesJS if not available
    document.addEventListener('DOMContentLoaded', () => {
      const script = document.createElement('script');
      script.onload = () => load(window);
      script.src = 'https://unpkg.com/grapesjs';
      document.head.appendChild(script);
    });
  }
})(window);