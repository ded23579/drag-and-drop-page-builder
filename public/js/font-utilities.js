// Fungsi utilitas untuk menambahkan font kustom ke GrapeJS
function addCustomFontToGrapeJS(editor) {
    if (!editor) {
        console.error('Editor is not available');
        return;
    }

    // Tambahkan command untuk menambahkan font kustom
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

    // Tambahkan tombol ke toolbar setelah editor selesai dimuat
    editor.on('load', function() {
        const pn = editor.Panels;
        
        // Tambahkan tombol untuk menambah font kustom
        pn.addButton('options', {
            id: 'add-font',
            className: 'gjs-font',
            command: 'add-custom-font',
            attributes: { title: 'Add Custom Font' }
        });
    });
}

// Tambahkan CSS untuk ikon font
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.innerHTML = `
        .gjs-font:before {
            content: "F";
            font-weight: bold;
        }
    `;
    document.head.appendChild(style);
});