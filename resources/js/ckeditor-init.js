import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

function initCkEditor(selector, livewireProperty) {
    const el = document.querySelector(selector);
    if (!el) return;

    ClassicEditor
        .create(el, {
            toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link']
        })
        .then(editor => {
            editor.editing.view.change(writer => {
                writer.setStyle("height", "155px", editor.editing.view.document.getRoot());
            });

            editor.model.document.on('change:data', () => {
                if (typeof window.livewire !== 'undefined') {
                    window.livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                        .set(livewireProperty, editor.getData());
                }
            });

            window.addEventListener('articleStore', () => {
                editor.setData('');
            });
        })
        .catch(error => {
            console.error(`CKEditor init error on ${selector}:`, error);
        });
}

// Inisialisasi editor setelah Livewire mount
document.addEventListener('livewire:load', () => {
    initCkEditor('#immediate_corrective_action', 'immediate_corrective_action');
    initCkEditor('#description', 'description');
});
