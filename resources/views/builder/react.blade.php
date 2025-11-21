@extends('layouts.app')

@section('title', 'React Builder')
@section('description', 'Build dynamic interfaces with our React component builder. Create interactive UIs with modern JavaScript framework.')
@section('keywords', 'react, javascript, builder, components, frontend, ui, interactive')

@section('content')
    <div style="height: 70vh; border: 1px solid #ccc; background: white; border-radius: 8px; display: flex; flex-direction: column; overflow: hidden;">
        <div id="gjs-react" style="flex: 1; padding: 20px;">
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

    <!-- Include GrapesJS JS and React Plugin -->
    @push('scripts')
    <script src="https://unpkg.com/grapesjs"></script>
    <script>
        // Initialize GrapesJS with React component support
        const editor = grapesjs.init({
            container: '#gjs-react',
            height: '100%',
            storageManager: false,
            fromElement: true,
            // Add React-like components
            components: `
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center my-4">React Component Builder</h1>
                            <p class="text-center lead">Build components that can be exported as React code</p>
                        </div>
                    </div>
                </div>
            `,
            blockManager: {
                blocks: [
                    {
                        id: 'react-component',
                        label: 'React Component',
                        content: '<div class="react-component"><h3>React Component</h3><p>A component ready for React export</p></div>',
                        category: 'React',
                        attributes: { class: 'gjs-fonts gjs-f-b1' }
                    },
                    {
                        id: 'jsx-code',
                        label: 'JSX Code',
                        content: '<div class="jsx-code"><p>Code will be generated here</p></div>',
                        category: 'React',
                        attributes: { class: 'gjs-fonts gjs-f-code' }
                    }
                ]
            }
        });

        // Set default style
        editor.setStyle(`
            body {
                padding: 20px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            
            .react-component {
                border: 2px dashed #3b82f6;
                padding: 20px;
                margin: 10px 0;
                background-color: #eff6ff;
                border-radius: 8px;
            }
            
            .jsx-code {
                background-color: #f3f4f6;
                padding: 15px;
                border-radius: 4px;
                font-family: monospace;
                white-space: pre-wrap;
            }
        `);
    </script>
    @endpush
@endsection