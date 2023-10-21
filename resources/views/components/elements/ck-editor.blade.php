<div class="field">
    <label class="label">{{ $label }}</label>
    <div wire:ignore class="control">
        <textarea wire:model="content" class="textarea ckeditor"
            id="{{$edId}}"
            name="{{$edId}}"
            placeholder="{{ $placeholder }}">
        </textarea>
    </div>

    <script>

        ClassicEditor
            .create(document.querySelector('#{{$edId}}'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

    </script>

</div>
