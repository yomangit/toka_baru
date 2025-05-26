<div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            /* min-height: 200px; */
            padding-left: 40px;
        }
    </style>
    <div role="tablist" class="tabs tabs-lifted">
        <input type="radio" name="my_tabs_2" role="tab" checked="checked" class="tab" aria-label="Event" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            <livewire:admin.people.event :user_id="$user_id">
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab " aria-label="Tab 2" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            <div id="toolbar-container"></div>
            <textarea name="editor" id="editor"></textarea>
            <script>
                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'
                    })
                    .then(newEditor3 => {
                        newEditor3.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",
                                newEditor3.editing.view.document.getRoot()
                            );
                        });

                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 3" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            Tab content
        </div>
    </div>



</div>
