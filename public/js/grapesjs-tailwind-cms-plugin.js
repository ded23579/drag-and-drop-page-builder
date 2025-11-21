// grapesjs-tailwind-cms-plugin.js
// A GrapesJS plugin for Tailwind CSS and CMS integration

(function() {
  'use strict';

  const GrapesJSTailwindCmsPlugin = (editor, opts = {}) => {
    const config = {
      enableAutocomplete: true,
      enablePresets: true,
      enableCMS: true,
      ...opts
    };

    // Add Tailwind CSS to the canvas
    editor.on('load', () => {
      const iframe = editor.Canvas.getBody();
      
      // Add Tailwind CSS to iframe
      const tailwindLink = iframe.ownerDocument.createElement('script');
      tailwindLink.src = 'https://cdn.tailwindcss.com';
      iframe.ownerDocument.head.appendChild(tailwindLink);
    });

    // Add Tailwind and CMS components
    if (config.enablePresets) {
      const blockManager = editor.BlockManager;

      // Add Tailwind-styled UI components
      blockManager.add('tailwind-card', {
        label: 'Tailwind Card',
        category: 'Tailwind',
        attributes: { class: 'gjs-font-weight-bold' },
        content: `
          <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white border border-gray-200">
            <div class="px-6 py-4">
              <div class="font-bold text-xl mb-2">Card Title</div>
              <p class="text-gray-700 text-base">
                This is a Tailwind CSS styled card component.
              </p>
            </div>
            <div class="px-6 pt-4 pb-2">
              <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#tailwind</span>
              <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#css</span>
            </div>
          </div>
        `
      });

      blockManager.add('tailwind-button', {
        label: 'Button',
        category: 'Tailwind',
        attributes: { class: 'gjs-font-weight-bold' },
        content: {
          type: 'button',
          classes: ['bg-blue-500', 'hover:bg-blue-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded'],
          content: 'Button'
        }
      });

      blockManager.add('tailwind-navbar', {
        label: 'Navbar',
        category: 'Tailwind',
        attributes: { class: 'gjs-font-weight-bold' },
        content: `
          <nav class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                  <div class="flex-shrink-0 font-bold text-xl">
                    Logo
                  </div>
                  <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">About</a>
                      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        `
      });

      blockManager.add('tailwind-jumbotron', {
        label: 'Jumbotron',
        category: 'Tailwind',
        attributes: { class: 'gjs-font-weight-bold' },
        content: `
          <div class="relative bg-cover bg-center py-24 px-4 sm:px-6 lg:px-8" style="background-image: url('https://via.placeholder.com/1200x600');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative max-w-7xl mx-auto text-center py-12 px-4 sm:px-6 lg:px-8 text-white">
              <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">Your Headline</h1>
              <p class="mt-4 max-w-3xl mx-auto text-xl">A compelling subheading that draws your visitors in.</p>
              <div class="mt-10">
                <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Get Started</a>
              </div>
            </div>
          </div>
        `
      });

      // Add CMS-specific blocks
      if (config.enableCMS) {
        // Strapi Content Block
        blockManager.add('cms-strapi', {
          label: 'Strapi Content',
          category: 'CMS',
          attributes: { class: 'gjs-font-weight-bold' },
          content: {
            type: 'text',
            content: 'Strapi Dynamic Content',
            attributes: { 'data-cms-type': 'strapi' },
            classes: ['bg-blue-100', 'p-4', 'border', 'border-blue-300', 'rounded']
          }
        });

        // Directus Data Block
        blockManager.add('cms-directus', {
          label: 'Directus Data',
          category: 'CMS',
          attributes: { class: 'gjs-font-weight-bold' },
          content: {
            type: 'text',
            content: 'Directus Dynamic Data',
            attributes: { 'data-cms-type': 'directus' },
            classes: ['bg-green-100', 'p-4', 'border', 'border-green-300', 'rounded']
          }
        });

        // Sanity Content Block
        blockManager.add('cms-sanity', {
          label: 'Sanity Content',
          category: 'CMS',
          attributes: { class: 'gjs-font-weight-bold' },
          content: {
            type: 'text',
            content: 'Sanity Dynamic Content',
            attributes: { 'data-cms-type': 'sanity' },
            classes: ['bg-purple-100', 'p-4', 'border', 'border-purple-300', 'rounded']
          }
        });

        // Contentful Content Block
        blockManager.add('cms-contentful', {
          label: 'Contentful Content',
          category: 'CMS',
          attributes: { class: 'gjs-font-weight-bold' },
          content: {
            type: 'text',
            content: 'Contentful Dynamic Content',
            attributes: { 'data-cms-type': 'contentful' },
            classes: ['bg-yellow-100', 'p-4', 'border', 'border-yellow-300', 'rounded']
          }
        });

        // Aimeos E-commerce Block
        blockManager.add('cms-aimeos', {
          label: 'Aimeos Product',
          category: 'CMS',
          attributes: { class: 'gjs-font-weight-bold' },
          content: {
            type: 'text',
            content: 'Aimeos E-commerce Content',
            attributes: { 'data-cms-type': 'aimeos' },
            classes: ['bg-red-100', 'p-4', 'border', 'border-red-300', 'rounded']
          }
        });
      }
    }

    // Add Tailwind CSS classes for autocomplete/suggestions
    if (config.enableAutocomplete) {
      // Create a comprehensive set of Tailwind CSS classes
      const tailwindClasses = [
        // Layout
        'container', 'box-border', 'block', 'inline-block', 'inline', 'flex', 'inline-flex',
        'table', 'inline-table', 'table-caption', 'table-cell', 'table-column', 'table-column-group',
        'table-footer-group', 'table-header-group', 'table-row-group', 'table-row',
        'flow-root', 'grid', 'inline-grid', 'contents', 'hidden',

        // Flexbox
        'flex-row', 'flex-row-reverse', 'flex-col', 'flex-col-reverse',
        'flex-wrap', 'flex-wrap-reverse', 'flex-no-wrap',
        'items-start', 'items-end', 'items-center', 'items-baseline', 'items-stretch',
        'self-auto', 'self-start', 'self-end', 'self-center', 'self-stretch',
        'justify-start', 'justify-end', 'justify-center', 'justify-between', 'justify-around', 'justify-evenly',
        'content-start', 'content-end', 'content-center', 'content-between', 'content-around', 'content-stretch',
        'flex-1', 'flex-auto', 'flex-initial', 'flex-none',

        // Spacing
        'p-0', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'p-6', 'p-8', 'p-10', 'p-12', 'p-16', 'p-20', 'p-24', 'p-32', 'p-40', 'p-48', 'p-56', 'p-64', 'p-px',
        'pt-0', 'pt-1', 'pt-2', 'pt-3', 'pt-4', 'pt-5', 'pt-6', 'pt-8', 'pt-10', 'pt-12', 'pt-16', 'pt-20', 'pt-24', 'pt-32', 'pt-40', 'pt-48', 'pt-56', 'pt-64', 'pt-px',
        'pr-0', 'pr-1', 'pr-2', 'pr-3', 'pr-4', 'pr-5', 'pr-6', 'pr-8', 'pr-10', 'pr-12', 'pr-16', 'pr-20', 'pr-24', 'pr-32', 'pr-40', 'pr-48', 'pr-56', 'pr-64', 'pr-px',
        'pb-0', 'pb-1', 'pb-2', 'pb-3', 'pb-4', 'pb-5', 'pb-6', 'pb-8', 'pb-10', 'pb-12', 'pb-16', 'pb-20', 'pb-24', 'pb-32', 'pb-40', 'pb-48', 'pb-56', 'pb-64', 'pb-px',
        'pl-0', 'pl-1', 'pl-2', 'pl-3', 'pl-4', 'pl-5', 'pl-6', 'pl-8', 'pl-10', 'pl-12', 'pl-16', 'pl-20', 'pl-24', 'pl-32', 'pl-40', 'pl-48', 'pl-56', 'pl-64', 'pl-px',
        'm-0', 'm-1', 'm-2', 'm-3', 'm-4', 'm-5', 'm-6', 'm-8', 'm-10', 'm-12', 'm-16', 'm-20', 'm-24', 'm-32', 'm-40', 'm-48', 'm-56', 'm-64', 'm-px', 'm-auto',
        'mt-0', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'mt-6', 'mt-8', 'mt-10', 'mt-12', 'mt-16', 'mt-20', 'mt-24', 'mt-32', 'mt-40', 'mt-48', 'mt-56', 'mt-64', 'mt-px', 'mt-auto',
        'mr-0', 'mr-1', 'mr-2', 'mr-3', 'mr-4', 'mr-5', 'mr-6', 'mr-8', 'mr-10', 'mr-12', 'mr-16', 'mr-20', 'mr-24', 'mr-32', 'mr-40', 'mr-48', 'mr-56', 'mr-64', 'mr-px', 'mr-auto',
        'mb-0', 'mb-1', 'mb-2', 'mb-3', 'mb-4', 'mb-5', 'mb-6', 'mb-8', 'mb-10', 'mb-12', 'mb-16', 'mb-20', 'mb-24', 'mb-32', 'mb-40', 'mb-48', 'mb-56', 'mb-64', 'mb-px', 'mb-auto',
        'ml-0', 'ml-1', 'ml-2', 'ml-3', 'ml-4', 'ml-5', 'ml-6', 'ml-8', 'ml-10', 'ml-12', 'ml-16', 'ml-20', 'ml-24', 'ml-32', 'ml-40', 'ml-40', 'ml-48', 'ml-56', 'ml-64', 'ml-px', 'ml-auto',
        'space-x-0', 'space-x-1', 'space-x-2', 'space-x-3', 'space-x-4', 'space-x-5', 'space-x-6', 'space-x-8', 'space-x-10', 'space-x-12', 'space-x-16', 'space-x-20', 'space-x-24', 'space-x-32', 'space-x-40', 'space-x-48', 'space-x-56', 'space-x-64', 'space-x-px',
        'space-y-0', 'space-y-1', 'space-y-2', 'space-y-3', 'space-y-4', 'space-y-5', 'space-y-6', 'space-y-8', 'space-y-10', 'space-y-12', 'space-y-16', 'space-y-20', 'space-y-24', 'space-y-32', 'space-y-40', 'space-y-48', 'space-y-56', 'space-y-64', 'space-y-px',

        // Typography
        'font-sans', 'font-serif', 'font-mono',
        'text-xs', 'text-sm', 'text-base', 'text-lg', 'text-xl', 'text-2xl', 'text-3xl', 'text-4xl', 'text-5xl', 'text-6xl', 'text-7xl', 'text-8xl', 'text-9xl',
        'antialiased', 'subpixel-antialiased',
        'italic', 'not-italic',
        'font-thin', 'font-extralight', 'font-light', 'font-normal', 'font-medium', 'font-semibold', 'font-bold', 'font-extrabold', 'font-black',
        'normal-nums', 'ordinal', 'slashed-zero', 'lining-nums', 'oldstyle-nums', 'proportional-nums', 'tabular-nums', 'diagonal-fractions', 'stacked-fractions',
        'tracking-tighter', 'tracking-tight', 'tracking-normal', 'tracking-wide', 'tracking-wider', 'tracking-widest',
        'normal-case', 'uppercase', 'lowercase', 'capitalize',
        'underline', 'line-through', 'no-underline',
        'placeholder-transparent', 'placeholder-current', 'placeholder-black', 'placeholder-white', 'placeholder-gray-50', 'placeholder-gray-100', 'placeholder-gray-200', 'placeholder-gray-300', 'placeholder-gray-400', 'placeholder-gray-500', 'placeholder-gray-600', 'placeholder-gray-700', 'placeholder-gray-800', 'placeholder-gray-900', 'placeholder-red-50', 'placeholder-red-100', 'placeholder-red-200', 'placeholder-red-300', 'placeholder-red-400', 'placeholder-red-500', 'placeholder-red-600', 'placeholder-red-700', 'placeholder-red-800', 'placeholder-red-900', 'placeholder-yellow-50', 'placeholder-yellow-100', 'placeholder-yellow-200', 'placeholder-yellow-300', 'placeholder-yellow-400', 'placeholder-yellow-500', 'placeholder-yellow-600', 'placeholder-yellow-700', 'placeholder-yellow-800', 'placeholder-yellow-900', 'placeholder-green-50', 'placeholder-green-100', 'placeholder-green-200', 'placeholder-green-300', 'placeholder-green-400', 'placeholder-green-500', 'placeholder-green-600', 'placeholder-green-700', 'placeholder-green-800', 'placeholder-green-900', 'placeholder-blue-50', 'placeholder-blue-100', 'placeholder-blue-200', 'placeholder-blue-300', 'placeholder-blue-400', 'placeholder-blue-500', 'placeholder-blue-600', 'placeholder-blue-700', 'placeholder-blue-800', 'placeholder-blue-900', 'placeholder-indigo-50', 'placeholder-indigo-100', 'placeholder-indigo-200', 'placeholder-indigo-300', 'placeholder-indigo-400', 'placeholder-indigo-500', 'placeholder-indigo-600', 'placeholder-indigo-700', 'placeholder-indigo-800', 'placeholder-indigo-900', 'placeholder-purple-50', 'placeholder-purple-100', 'placeholder-purple-200', 'placeholder-purple-300', 'placeholder-purple-400', 'placeholder-purple-500', 'placeholder-purple-600', 'placeholder-purple-700', 'placeholder-purple-800', 'placeholder-purple-900', 'placeholder-pink-50', 'placeholder-pink-100', 'placeholder-pink-200', 'placeholder-pink-300', 'placeholder-pink-400', 'placeholder-pink-500', 'placeholder-pink-600', 'placeholder-pink-700', 'placeholder-pink-800', 'placeholder-pink-900',
        'align-baseline', 'align-top', 'align-middle', 'align-bottom', 'align-text-top', 'align-text-bottom',

        // Backgrounds
        'bg-fixed', 'bg-local', 'bg-scroll',
        'bg-clip-border', 'bg-clip-padding', 'bg-clip-content', 'bg-clip-text',
        'bg-transparent', 'bg-current', 'bg-black', 'bg-white', 'bg-gray-50', 'bg-gray-100', 'bg-gray-200', 'bg-gray-300', 'bg-gray-400', 'bg-gray-500', 'bg-gray-600', 'bg-gray-700', 'bg-gray-800', 'bg-gray-900', 'bg-red-50', 'bg-red-100', 'bg-red-200', 'bg-red-300', 'bg-red-400', 'bg-red-500', 'bg-red-600', 'bg-red-700', 'bg-red-800', 'bg-red-900', 'bg-yellow-50', 'bg-yellow-100', 'bg-yellow-200', 'bg-yellow-300', 'bg-yellow-400', 'bg-yellow-500', 'bg-yellow-600', 'bg-yellow-700', 'bg-yellow-800', 'bg-yellow-900', 'bg-green-50', 'bg-green-100', 'bg-green-200', 'bg-green-300', 'bg-green-400', 'bg-green-500', 'bg-green-600', 'bg-green-700', 'bg-green-800', 'bg-green-900', 'bg-blue-50', 'bg-blue-100', 'bg-blue-200', 'bg-blue-300', 'bg-blue-400', 'bg-blue-500', 'bg-blue-600', 'bg-blue-700', 'bg-blue-800', 'bg-blue-900', 'bg-indigo-50', 'bg-indigo-100', 'bg-indigo-200', 'bg-indigo-300', 'bg-indigo-400', 'bg-indigo-500', 'bg-indigo-600', 'bg-indigo-700', 'bg-indigo-800', 'bg-indigo-900', 'bg-purple-50', 'bg-purple-100', 'bg-purple-200', 'bg-purple-300', 'bg-purple-400', 'bg-purple-500', 'bg-purple-600', 'bg-purple-700', 'bg-purple-800', 'bg-purple-900', 'bg-pink-50', 'bg-pink-100', 'bg-pink-200', 'bg-pink-300', 'bg-pink-400', 'bg-pink-500', 'bg-pink-600', 'bg-pink-700', 'bg-pink-800', 'bg-pink-900',
        'bg-bottom', 'bg-center', 'bg-left', 'bg-left-bottom', 'bg-left-top', 'bg-right', 'bg-right-bottom', 'bg-right-top', 'bg-top',
        'bg-repeat', 'bg-no-repeat', 'bg-repeat-x', 'bg-repeat-y', 'bg-repeat-round', 'bg-repeat-space',
        'bg-auto', 'bg-cover', 'bg-contain',

        // Borders
        'border', 'border-0', 'border-2', 'border-4', 'border-8',
        'border-t', 'border-r', 'border-b', 'border-l',
        'border-solid', 'border-dashed', 'border-dotted', 'border-double',
        'border-transparent', 'border-current', 'border-black', 'border-white', 'border-gray-50', 'border-gray-100', 'border-gray-200', 'border-gray-300', 'border-gray-400', 'border-gray-500', 'border-gray-600', 'border-gray-700', 'border-gray-800', 'border-gray-900', 'border-red-50', 'border-red-100', 'border-red-200', 'border-red-300', 'border-red-400', 'border-red-500', 'border-red-600', 'border-red-700', 'border-red-800', 'border-red-900', 'border-yellow-50', 'border-yellow-100', 'border-yellow-200', 'border-yellow-300', 'border-yellow-400', 'border-yellow-500', 'border-yellow-600', 'border-yellow-700', 'border-yellow-800', 'border-yellow-900', 'border-green-50', 'border-green-100', 'border-green-200', 'border-green-300', 'border-green-400', 'border-green-500', 'border-green-600', 'border-green-700', 'border-green-800', 'border-green-900', 'border-blue-50', 'border-blue-100', 'border-blue-200', 'border-blue-300', 'border-blue-400', 'border-blue-500', 'border-blue-600', 'border-blue-700', 'border-blue-800', 'border-blue-900', 'border-indigo-50', 'border-indigo-100', 'border-indigo-200', 'border-indigo-300', 'border-indigo-400', 'border-indigo-500', 'border-indigo-600', 'border-indigo-700', 'border-indigo-800', 'border-indigo-900', 'border-purple-50', 'border-purple-100', 'border-purple-200', 'border-purple-300', 'border-purple-400', 'border-purple-500', 'border-purple-600', 'border-purple-700', 'border-purple-800', 'border-purple-900', 'border-pink-50', 'border-pink-100', 'border-pink-200', 'border-pink-300', 'border-pink-400', 'border-pink-500', 'border-pink-600', 'border-pink-700', 'border-pink-800', 'border-pink-900',
        'rounded-none', 'rounded-sm', 'rounded', 'rounded-md', 'rounded-lg', 'rounded-xl', 'rounded-2xl', 'rounded-3xl', 'rounded-full',
        'rounded-t-none', 'rounded-t-sm', 'rounded-t', 'rounded-t-md', 'rounded-t-lg', 'rounded-t-xl', 'rounded-t-2xl', 'rounded-t-3xl', 'rounded-t-full',
        'rounded-r-none', 'rounded-r-sm', 'rounded-r', 'rounded-r-md', 'rounded-r-lg', 'rounded-r-xl', 'rounded-r-2xl', 'rounded-r-3xl', 'rounded-r-full',
        'rounded-b-none', 'rounded-b-sm', 'rounded-b', 'rounded-b-md', 'rounded-b-lg', 'rounded-b-xl', 'rounded-b-2xl', 'rounded-b-3xl', 'rounded-b-full',
        'rounded-l-none', 'rounded-l-sm', 'rounded-l', 'rounded-l-md', 'rounded-l-lg', 'rounded-l-xl', 'rounded-l-2xl', 'rounded-l-3xl', 'rounded-l-full',
        'rounded-tl-none', 'rounded-tl-sm', 'rounded-tl', 'rounded-tl-md', 'rounded-tl-lg', 'rounded-tl-xl', 'rounded-tl-2xl', 'rounded-tl-3xl', 'rounded-tl-full',
        'rounded-tr-none', 'rounded-tr-sm', 'rounded-tr', 'rounded-tr-md', 'rounded-tr-lg', 'rounded-tr-xl', 'rounded-tr-2xl', 'rounded-tr-3xl', 'rounded-tr-full',
        'rounded-bl-none', 'rounded-bl-sm', 'rounded-bl', 'rounded-bl-md', 'rounded-bl-lg', 'rounded-bl-2xl', 'rounded-bl-3xl', 'rounded-bl-full',
        'rounded-br-none', 'rounded-br-sm', 'rounded-br', 'rounded-br-md', 'rounded-br-lg', 'rounded-br-xl', 'rounded-br-2xl', 'rounded-br-3xl', 'rounded-br-full',

        // Effects
        'shadow-sm', 'shadow', 'shadow-md', 'shadow-lg', 'shadow-xl', 'shadow-2xl', 'shadow-inner', 'shadow-none',
        'opacity-0', 'opacity-5', 'opacity-10', 'opacity-20', 'opacity-25', 'opacity-30', 'opacity-40', 'opacity-50', 'opacity-60', 'opacity-70', 'opacity-75', 'opacity-80', 'opacity-90', 'opacity-95', 'opacity-100',

        // Transitions
        'transition-none', 'transition-all', 'transition', 'transition-colors', 'transition-opacity', 'transition-shadow', 'transition-transform',

        // Interactivity
        'cursor-auto', 'cursor-default', 'cursor-pointer', 'cursor-wait', 'cursor-text', 'cursor-move', 'cursor-not-allowed',
        'resize-none', 'resize-y', 'resize-x', 'resize',
        'list-none', 'list-disc', 'list-decimal',

        // Tables
        'border-collapse', 'border-separate',

        // Transforms
        'scale-0', 'scale-50', 'scale-75', 'scale-90', 'scale-95', 'scale-100', 'scale-105', 'scale-110', 'scale-125', 'scale-150',
        'rotate-0', 'rotate-1', 'rotate-2', 'rotate-3', 'rotate-6', 'rotate-12', 'rotate-45', 'rotate-90', 'rotate-180',
        'translate-x-0', 'translate-x-1', 'translate-x-2', 'translate-x-3', 'translate-x-4', 'translate-x-5', 'translate-x-6', 'translate-x-8', 'translate-x-10', 'translate-x-12', 'translate-x-16', 'translate-x-20', 'translate-x-24', 'translate-x-32', 'translate-x-40', 'translate-x-48', 'translate-x-56', 'translate-x-64', 'translate-x-px', 'translate-x-full', 'translate-x-1/2', 'translate-x-1/3', 'translate-x-2/3', 'translate-x-1/4', 'translate-x-2/4', 'translate-x-3/4', 'translate-x-1/5', 'translate-x-2/5', 'translate-x-3/5', 'translate-x-4/5', 'translate-x-1/6', 'translate-x-2/6', 'translate-x-3/6', 'translate-x-4/6', 'translate-x-5/6', 'translate-x-1/12', 'translate-x-2/12', 'translate-x-3/12', 'translate-x-4/12', 'translate-x-5/12', 'translate-x-6/12', 'translate-x-7/12', 'translate-x-8/12', 'translate-x-9/12', 'translate-x-10/12', 'translate-x-11/12', 'translate-x-full',
        'translate-y-0', 'translate-y-1', 'translate-y-2', 'translate-y-3', 'translate-y-4', 'translate-y-5', 'translate-y-6', 'translate-y-8', 'translate-y-10', 'translate-y-12', 'translate-y-16', 'translate-y-20', 'translate-y-24', 'translate-y-32', 'translate-y-40', 'translate-y-48', 'translate-y-56', 'translate-y-64', 'translate-y-px', 'translate-y-full', 'translate-y-1/2', 'translate-y-1/3', 'translate-y-2/3', 'translate-y-1/4', 'translate-y-2/4', 'translate-y-3/4', 'translate-y-1/5', 'translate-y-2/5', 'translate-y-3/5', 'translate-y-4/5', 'translate-y-1/6', 'translate-y-2/6', 'translate-y-3/6', 'translate-y-4/6', 'translate-y-5/6', 'translate-y-1/12', 'translate-y-2/12', 'translate-y-3/12', 'translate-y-4/12', 'translate-y-5/12', 'translate-y-6/12', 'translate-y-7/12', 'translate-y-8/12', 'translate-y-9/12', 'translate-y-10/12', 'translate-y-11/12', 'translate-y-full',

        // Filters
        'blur-none', 'blur-sm', 'blur', 'blur-md', 'blur-lg', 'blur-xl', 'blur-2xl', 'blur-3xl',
        'brightness-0', 'brightness-50', 'brightness-75', 'brightness-90', 'brightness-95', 'brightness-100', 'brightness-105', 'brightness-110', 'brightness-125', 'brightness-150', 'brightness-200',
        'contrast-0', 'contrast-50', 'contrast-75', 'contrast-100', 'contrast-125', 'contrast-150', 'contrast-200',
        'drop-shadow-sm', 'drop-shadow', 'drop-shadow-md', 'drop-shadow-lg', 'drop-shadow-xl', 'drop-shadow-2xl', 'drop-shadow-none',
        'grayscale-0', 'grayscale',
        'hue-rotate-0', 'hue-rotate-15', 'hue-rotate-30', 'hue-rotate-60', 'hue-rotate-90', 'hue-rotate-180',
        'invert-0', 'invert',
        'saturate-0', 'saturate-50', 'saturate-100', 'saturate-150', 'saturate-200',
        'sepia-0', 'sepia',
        'backdrop-blur-none', 'backdrop-blur-sm', 'backdrop-blur', 'backdrop-blur-md', 'backdrop-blur-lg', 'backdrop-blur-xl', 'backdrop-blur-2xl', 'backdrop-blur-3xl',
        'backdrop-brightness-0', 'backdrop-brightness-50', 'backdrop-brightness-75', 'backdrop-brightness-90', 'backdrop-brightness-95', 'backdrop-brightness-100', 'backdrop-brightness-105', 'backdrop-brightness-110', 'backdrop-brightness-125', 'backdrop-brightness-150', 'backdrop-brightness-200',
        'backdrop-contrast-0', 'backdrop-contrast-50', 'backdrop-contrast-75', 'backdrop-contrast-100', 'backdrop-contrast-125', 'backdrop-contrast-150', 'backdrop-contrast-200',
        'backdrop-grayscale-0', 'backdrop-grayscale',
        'backdrop-hue-rotate-0', 'backdrop-hue-rotate-15', 'backdrop-hue-rotate-30', 'backdrop-hue-rotate-60', 'backdrop-hue-rotate-90', 'backdrop-hue-rotate-180',
        'backdrop-invert-0', 'backdrop-invert',
        'backdrop-opacity-0', 'backdrop-opacity-5', 'backdrop-opacity-10', 'backdrop-opacity-20', 'backdrop-opacity-25', 'backdrop-opacity-30', 'backdrop-opacity-40', 'backdrop-opacity-50', 'backdrop-opacity-60', 'backdrop-opacity-70', 'backdrop-opacity-75', 'backdrop-opacity-80', 'backdrop-opacity-90', 'backdrop-opacity-95', 'backdrop-opacity-100',
        'backdrop-saturate-0', 'backdrop-saturate-50', 'backdrop-saturate-100', 'backdrop-saturate-150', 'backdrop-saturate-200',
        'backdrop-sepia-0', 'backdrop-sepia'
      ];

      // Set up class suggestions
      editor.on('component:selected', function(component) {
        // Create a list of suggested Tailwind classes based on current component type
        const tagName = component.get('tagName');
        let suggestedClasses = tailwindClasses;
        
        if (tagName === 'button') {
          suggestedClasses = tailwindClasses.filter(cls => 
            cls.startsWith('bg-') || cls.startsWith('text-') || cls.startsWith('font-') || cls.startsWith('p-') || cls.startsWith('rounded') || cls.startsWith('shadow'));
        } else if (tagName === 'img') {
          suggestedClasses = tailwindClasses.filter(cls => 
            cls.startsWith('w-') || cls.startsWith('h-') || cls.startsWith('rounded') || cls.startsWith('border') || cls.startsWith('object-'));
        } else if (tagName === 'input' || tagName === 'textarea') {
          suggestedClasses = tailwindClasses.filter(cls => 
            cls.startsWith('w-') || cls.startsWith('h-') || cls.startsWith('p-') || cls.startsWith('border') || cls.startsWith('rounded') || cls.startsWith('focus:'));
        }

        // Log suggestions to console for now
        console.log('Suggested Tailwind classes for', tagName + ':', suggestedClasses.slice(0, 10));
      });
    }

    // Add CMS integration features
    if (config.enableCMS) {
      // Add a custom command to show CMS integration panel
      editor.Commands.add('open-cms-panel', {
        run: function(editor) {
          // Create a modal or panel for CMS integration
          const cmsPanel = document.createElement('div');
          cmsPanel.innerHTML = `
            <div style="
              position: fixed;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              background: white;
              padding: 20px;
              border-radius: 8px;
              box-shadow: 0 4px 6px rgba(0,0,0,0.1);
              z-index: 9999;
              width: 500px;
            ">
              <h3 style="margin: 0 0 15px; font-size: 1.2em;">CMS Integrations</h3>
              
              <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Strapi Configuration</div>
                <input type="text" placeholder="API URL" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="API Token" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
              </div>
              
              <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Directus Configuration</div>
                <input type="text" placeholder="Project URL" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Username" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="password" placeholder="Password" style="width: 100%; padding: 8px;"/>
              </div>
              
              <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Sanity Configuration</div>
                <input type="text" placeholder="Project ID" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Dataset" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Token" style="width: 100%; padding: 8px;"/>
              </div>
              
              <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Contentful Configuration</div>
                <input type="text" placeholder="Space ID" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Access Token" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Environment" style="width: 100%; padding: 8px;"/>
              </div>
              
              <div style="margin-bottom: 15px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Aimeos Configuration</div>
                <input type="text" placeholder="Shop URL" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="text" placeholder="Username" style="width: 100%; padding: 8px; margin-bottom: 5px;"/>
                <input type="password" placeholder="Password" style="width: 100%; padding: 8px;"/>
              </div>
              
              <button id="close-cms-modal" style="
                padding: 10px 20px;
                background: #3b82f6;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
              ">Close</button>
            </div>
            
            <div id="cms-overlay" style="
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: rgba(0,0,0,0.5);
              z-index: 9998;
            "></div>
          `;
          
          document.body.appendChild(cmsPanel);
          
          document.getElementById('close-cms-modal').onclick = () => {
            document.body.removeChild(cmsPanel);
          };
          
          document.getElementById('cms-overlay').onclick = () => {
            document.body.removeChild(cmsPanel);
          };
        }
      });

      // Add a button to the component toolbar for CMS settings
      editor.on('run:tlb-delete', function() {
        const selected = editor.getSelected();
        if (selected) {
          // Add CMS settings button to the component toolbar
          const toolbar = selected.get('toolbar');
          if (!toolbar.find(btn => btn.command === 'open-cms-panel')) {
            toolbar.unshift({
              label: 'CMS',
              command: 'open-cms-panel',
              text: 'CMS'
            });
          }
        }
      });
      
      // Add a CMS integration button to the main UI
      const panelManager = editor.Panels;
      panelManager.addButton('options', {
        id: 'cms-integration',
        className: 'fa fa-database',
        command: 'open-cms-panel',
        attributes: { title: 'CMS Integration' }
      });
    }
  };

  // Define the plugin
  window.grapesjs.plugins.add('grapesjs-tailwind-cms', GrapesJSTailwindCmsPlugin);
})();