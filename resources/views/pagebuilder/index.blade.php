@extends('layouts.app')

@section('title', 'Page Builder')
@section('description', 'Create beautiful pages with our intuitive page builder. Drag and drop elements to design your perfect webpage.')
@section('keywords', 'page builder, drag and drop, webpage design, content management, web development')

@section('header-actions')
    <button type="button" class="btn btn-primary" id="save-btn">
        <i class="fas fa-save"></i> Save Page
    </button>
@endsection

@section('content')
    <!-- GrapesJS editor container with proper layout -->
    <div style="height: 70vh; border: 1px solid #ccc; background: white; border-radius: 8px; display: flex; flex-direction: column; overflow: hidden;">
        <!-- Editor area with panels -->
        <div id="gjs">
            <!-- GrapesJS UI will be injected here -->
        </div>
    </div>

    <!-- Include GrapesJS CSS -->
    @push('head')
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet" />
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .gjs-font:before {
            content: "F";
            font-weight: bold;
        }
    </style>
    @endpush

    <!-- Include GrapesJS JS and Plugins -->
    @push('scripts')
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-script-editor"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
    <script src="https://unpkg.com/grapesjs-component-countdown"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
    <script src="https://unpkg.com/grapesjs-tailwind"></script>
    <script src="https://unpkg.com/grapesjs-custom-code"></script>
    <script src="https://unpkg.com/grapesjs-touch"></script>
    <script src="{{ asset('js/font-utilities.js') }}"></script>
    <script>
        // Initialize GrapesJS with proper UI layout
        const editor = grapesjs.init({
            container: '#gjs',
            // Use the built-in UI panels instead of custom appendTo
            height: '70vh',
            storageManager: false, // Disable local storage for now
            fromElement: true, // Use the content from the container as starting point
            plugins: [
                'grapesjs-script-editor',
                'grapesjs-blocks-basic',
                'grapesjs-component-countdown',
                'grapesjs-plugin-forms',
                'grapesjs-tailwind',
                'grapesjs-custom-code',
                'grapesjs-touch'
            ],
            pluginsOpts: {
                'grapesjs-script-editor': {
                    // Configuration options for the script editor plugin
                },
                'grapesjs-blocks-basic': {
                    // Basic blocks configuration
                    blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'image', 'video', 'button', 'container'],
                    category: 'Basic',
                },
                'grapesjs-component-countdown': {
                    // Component countdown configuration
                },
                'grapesjs-plugin-forms': {
                    // Forms plugin configuration
                    blocks: ['form', 'input', 'textarea', 'select', 'button', 'label', 'checkbox', 'radio'],
                },
                'grapesjs-tailwind': {
                    // Tailwind CSS plugin configuration
                    blocks: ['container', 'row', 'text', 'image', 'button'],
                },
                'grapesjs-custom-code': {
                    // Custom code plugin options
                },
                'grapesjs-touch': {
                    // Touch support options
                }
            },
            canvas: {
                styles: [
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
                    'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;500;600;700&family=Oswald:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Raleway:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&family=Anton:wght@400&family=Bebas+Neue:wght@400&family=Abril+Fatface:wght@400&family=Great+Vibes:wght@400&family=Kaushan+Script:wght@400&family=Sacramento:wght@400&family=Alex+Brush:wght@400&family=Parisienne:wght@400&family=Satisfy:wght@400&family=Dancing+Script:wght@400;500;600;700&family=Cookie:wght@400&family=Lobster:wght@400&family=Courgette:wght@400&family=Indie+Flower:wght@400&family=Pacifico:wght@400&family=Cinzel:wght@300;400;500;600;700&family=Orbitron:wght@300;400;500;600;700&family=UnifrakturMaguntia:wght@400&family=MedievalSharp:wght@400&display=swap'
                ],
                scripts: [
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
                ]
            },
            assetManager: {
                upload: "{{ route('page-builder.save') }}",
                uploadName: 'files',
                multiUpload: true,
                assets: [],
            },
            selectorManager: {
                componentFirst: true,
            },
            styleManager: {
                sectors: [{
                    name: 'General',
                    open: false,
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
                }, {
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'flex-grow', 'flex-shrink', 'flex-basis']
                }, {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding']
                }, {
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-decoration'],
                    properties: [{
                        type: 'select',
                        name: 'Font Family',
                        property: 'font-family',
                        list: [
                            { name: 'Arial', value: 'Arial, Helvetica, sans-serif' },
                            { name: 'Helvetica', value: 'Helvetica, Arial, sans-serif' },
                            { name: 'Times New Roman', value: '"Times New Roman", Times, serif' },
                            { name: 'Georgia', value: 'Georgia, serif' },
                            { name: 'Open Sans', value: '"Open Sans", sans-serif' },
                            { name: 'Roboto', value: 'Roboto, sans-serif' },
                            { name: 'Montserrat', value: 'Montserrat, sans-serif' },
                            { name: 'Oswald', value: 'Oswald, sans-serif' },
                            { name: 'Playfair Display', value: '"Playfair Display", serif' },
                            { name: 'Raleway', value: 'Raleway, sans-serif' },
                            { name: 'Merriweather', value: 'Merriweather, serif' },
                            { name: 'Poppins', value: 'Poppins, sans-serif' },
                            { name: 'Anton', value: 'Anton, sans-serif' },
                            { name: 'Bebas Neue', value: '"Bebas Neue", sans-serif' },
                            { name: 'Abril Fatface', value: '"Abril Fatface", serif' },
                            { name: 'Great Vibes', value: '"Great Vibes", cursive' },
                            { name: 'Kaushan Script', value: '"Kaushan Script", cursive' },
                            { name: 'Sacramento', value: '"Sacramento", cursive' },
                            { name: 'Alex Brush', value: '"Alex Brush", cursive' },
                            { name: 'Parisienne', value: 'Parisienne, cursive' },
                            { name: 'Satisfy', value: 'Satisfy, cursive' },
                            { name: 'Dancing Script', value: '"Dancing Script", cursive' },
                            { name: 'Cookie', value: 'Cookie, cursive' },
                            { name: 'Lobster', value: 'Lobster, cursive' },
                            { name: 'Courgette', value: 'Courgette, cursive' },
                            { name: 'Indie Flower', value: '"Indie Flower", cursive' },
                            { name: 'Pacifico', value: 'Pacifico, cursive' },
                            { name: 'Cinzel', value: 'Cinzel, serif' },
                            { name: 'Orbitron', value: 'Orbitron, sans-serif' },
                            { name: 'UnifrakturMaguntia', value: '"UnifrakturMaguntia", serif' },
                            { name: 'MedievalSharp', value: 'MedievalSharp, serif' }
                        ]
                    }]
                }, {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background']
                }, {
                    name: 'Extra',
                    open: false,
                    buildProps: ['transition', 'perspective', 'transform']
                }]
            },
            layerManager: {
                // Use default positioning
                appendTo: '',
                showLayers: true
            },
            traitManager: {
                // Use default positioning
                appendTo: '',
                groups: [{
                    id: 'core',
                    label: 'Core'
                }, {
                    id: 'extra',
                    label: 'Extra'
                }, {
                    id: 'advanced',
                    label: 'Advanced'
                }],
                // Extend default traits
                extendConn: true,
            },
            blockManager: {
                // Use default positioning
                appendTo: '',
                blocks: [
                    {
                        id: 'header',
                        label: 'Header',
                        content: '<header class="header"><div class="container"><h1>Header</h1></div></header>',
                        category: 'Basic',
                        select: true,
                    },
                    {
                        id: 'footer',
                        label: 'Footer',
                        content: '<footer class="footer"><div class="container"><p>Footer</p></div></footer>',
                        category: 'Basic',
                        select: true,
                    }
                ]
            },
            // Additional configurations
            richTextEditor: {
                // Configuration for the rich text editor
            },
            modal: {
                backdrop: true
            },
            deviceManager: {
                devices: [{
                    name: 'Desktop',
                    width: '',
                }, {
                    name: 'Mobile',
                    width: '320px',
                    widthMedia: '480px',
                }]
            }
        });

        // Tambahkan fungsionalitas font kustom setelah inisialisasi editor
        addCustomFontToGrapeJS(editor);

        // Add default content to the editor
        editor.setComponents(`
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center my-4">Welcome to the Page Builder</h1>
                        <p class="text-center lead">Drag components from the panels to start building your page.</p>
                        <div class="row mt-5">
                            <div class="col-md-4 text-center">
                                <i class="fas fa-mouse-pointer fa-3x text-primary mb-3"></i>
                                <h4>Drag & Drop</h4>
                                <p>Simply drag elements to build your page</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                                <h4>Customize</h4>
                                <p>Change colors, fonts, and styles</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-save fa-3x text-primary mb-3"></i>
                                <h4>Save & Publish</h4>
                                <p>Save your creations with one click</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);

        // Set default style
        editor.setStyle(`
            body {
                padding: 20px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
        `);

        // Save button functionality
        document.getElementById('save-btn').addEventListener('click', function() {
            const content = editor.getHtml();
            const css = editor.getCss();

            fetch("{{ route('page-builder.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    content: content,
                    css: css,
                    title: document.querySelector('title').textContent || 'Untitled Page'
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Page saved successfully!');
                } else {
                    alert('Error saving page: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving page: ' + error.message);
            });
        });
    </script>
    @endpush
@endsection