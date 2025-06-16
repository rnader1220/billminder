import tinymce from 'tinymce/tinymce';

// 👇 Import what you need (skip skin CSS if you're using your own)
import 'tinymce/icons/default';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';

// 👇 Commonly used plugins — import only what you use
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
// ... add more as needed

// Optional: CSS (you can skip this if you’re rolling your own styles)
import 'tinymce/skins/ui/oxide/skin.css';
import 'tinymce/skins/content/default/content.css';

window.editor = (function () {
    const default_options = {
            selector: 'textarea.tinymce',
            height: 120,
            menubar: false,
            plugins: 'lists link paste',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
            branding: false,
            statusbar: false,
            paste_as_text: true, 
            license_key: 'gpl',
            content_css: '/css/app.css',
            cache_suffix: '?v=' + new Date().getTime()
                }

    // include alternate selector in options if needed
    function init(options = {}) {
        tinymce.init(Object.assign({}, default_options, options));
    }

    function kill(selector = 'textarea.tinymce') {
        tinymce.remove(selector);
    }

    function getContent() {
        const data = {};
        document.querySelectorAll('textarea.tinymce').forEach(el => {
            const editor = tinymce.get(el.id);
            if (editor) {
                data[el.name] = editor.getContent();
            }
        });
        return data;
    }
    return {
        init,
        kill,
        getContent
    };
})();