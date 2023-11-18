<div class="field content">
    <label class="label">{{ $label }}</label>
    <div wire:ignore class="control">
        <textarea wire:model="content" class="textarea ckeditor"
            id="{{$edId}}"
            name="{{$edId}}"
            placeholder="{{ $placeholder }}">
        </textarea>
    </div>

    <input type="hidden" id="H{{$edId}}" value="{{ $content }}">

    <script>

        const editor_config{{$edId}} = {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        } 







        ClassicEditor
            .create(document.querySelector('#{{$edId}}',editor_config{{$edId}}))
            .then(editor => {
                
                editor.setData( document.getElementById('H{{$edId}}').value );
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

    </script>

</div>
