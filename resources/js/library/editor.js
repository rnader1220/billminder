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
            height: 600,
            menubar: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            skin_url: '/vendor/tinymce/skins/ui/oxide',
            content_css: '/vendor/tinymce/skins/content/default/content.css'
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