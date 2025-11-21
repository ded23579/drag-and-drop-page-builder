@extends('layouts.app')

@section('title', 'Tailwind Builder')
@section('description', 'Design stunning interfaces with our Tailwind CSS builder. Create responsive layouts with utility-first CSS framework.')
@section('keywords', 'tailwind, css, builder, responsive design, utility classes, frontend development')

@section('content')
    <div style="height: 70vh; border: 1px solid #ccc; background: white; border-radius: 8px; display: flex; flex-direction: column; overflow: hidden;">
        <div id="gjs-tailwind" style="flex: 1; padding: 20px;">
            <!-- GrapesJS UI will be injected here -->
        </div>
    </div>

    <!-- Include GrapesJS CSS -->
    @push('head')
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet" />
    <style>
        body {
            overflow: auto;
        }
    </style>
    @endpush

    <!-- Include GrapesJS JS and Tailwind Plugin -->
    @push('scripts')
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/grapesjs-tailwind-plugin.js') }}"></script>
    <script>
        // Initialize GrapesJS with Tailwind integration
        const editor = grapesjs.init({
            container: '#gjs-tailwind',
            height: '100%',
            storageManager: false,
            fromElement: true,
            container: '#gjs-tailwind',
            plugins: ['grapesjs-tailwind'],
            pluginsOpts: {
                'grapesjs-tailwind': {
                    // Tailwind plugin options
                }
            },
            canvas: {
                styles: [
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
                ],
                scripts: [
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
                ]
            },
            // Set default content for Tailwind builder
            components: `
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-3xl font-bold text-center mb-6">Tailwind CSS Page Builder</h1>
                    <p class="text-center mb-8 text-gray-600">Drag and drop components to build your page with Tailwind CSS classes</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-3">Component 1</h3>
                            <p class="text-gray-600">This is a sample component built with Tailwind CSS classes.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-3">Component 2</h3>
                            <p class="text-gray-600">This is a sample component built with Tailwind CSS classes.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-3">Component 3</h3>
                            <p class="text-gray-600">This is a sample component built with Tailwind CSS classes.</p>
                        </div>
                    </div>
                </div>
            `
        });

        // Set default style
        editor.setStyle(`
            body {
                padding: 20px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
        `);
    </script>
    @endpush
@endsection