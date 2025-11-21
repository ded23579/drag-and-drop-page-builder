// Plugin sederhana untuk menambahkan dukungan font kustom ke GrapeJS
(function() {
    'use strict';

    if (typeof window.grapesjs === 'undefined') {
        console.error('GrapesJS is not available');
        return;
    }

    window.grapesjs.plugins.add('grapesjs-font-picker', {
        init: function(editor, options) {
            // Hanya tambahkan command untuk menambah font kustom
            editor.Commands.add('add-custom-font', {
                run: function() {
                    const fontName = prompt('Enter font name (e.g., "Roboto") or CSS URL:');
                    if (fontName) {
                        let fontUrl, fontFamily;
                        
                        if (fontName.startsWith('http')) {
                            // Ini adalah URL font
                            fontUrl = fontName;
                            fontFamily = fontName.split('/').pop().split('?')[0].split('.')[0].replace(/[^a-zA-Z0-9]/g, ' ').trim() || 'Custom Font';
                        } else {
                            // Ini adalah nama font Google
                            fontFamily = fontName;
                            fontUrl = `https://fonts.googleapis.com/css2?family=${fontFamily.replace(/ /g, '+')}:wght@300;400;500;600;700&display=swap`;
                        }

                        // Tambahkan CSS font ke head dokumen canvas
                        const canvas = editor.Canvas.getDocument();
                        if (fontUrl) {
                            const existingLink = canvas.querySelector(`link[href*="${fontFamily}"]`);
                            if (!existingLink) {
                                const link = document.createElement('link');
                                link.rel = 'stylesheet';
                                link.type = 'text/css';
                                link.href = fontUrl;
                                canvas.head.appendChild(link);
                            }
                        }

                        // Terapkan font ke elemen yang dipilih
                        const selected = editor.getSelected();
                        if (selected) {
                            selected.addStyle({ 'font-family': `"${fontFamily}", sans-serif` });
                        }
                    }
                }
            });
        }
    });
})();