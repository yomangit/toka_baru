import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

window.initCKEditor = function (selector, callback = null) {
    const element = document.querySelector(selector);
    if (!element) return;

    ClassicEditor.create(element, {
        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
    })
        .then(editor => {
            // Tambah tinggi editor
            editor.editing.view.change(writer => {
                writer.setStyle('height', '155px', editor.editing.view.document.getRoot());
            });

            // Event sync ke Livewire
            editor.model.document.on('change:data', () => {
                if (typeof callback === 'function') {
                    callback(editor.getData());
                }
            });

            window.addEventListener('articleStore', () => {
                editor.setData('');
            });
        })
        .catch(error => {
            console.error('CKEditor init error:', error);
        });
};
