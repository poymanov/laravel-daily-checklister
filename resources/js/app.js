require('./bootstrap');
require('perfect-scrollbar');
require('@popperjs/core');
require('@coreui/coreui');

ClassicEditor = require('@ckeditor/ckeditor5-build-classic');

createEditor('#task-description');
createEditor('#page-content');

function createEditor(selector) {
    if (!document.querySelector(selector)) {
        return;
    }

    ClassicEditor
        .create(document.querySelector(selector))
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
}
