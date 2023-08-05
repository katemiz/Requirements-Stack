
{{-- 
<div class="has-background-info-light p-3">

    <script src="{{ asset('/js/attachment.js') }}"></script>



    <x-title :params="$headers" />

    <form action="/upload-attach/requirement/12" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="filesToUpload" value="0" autocomplete="off">
        <input type="hidden" id="filesToDelete" name="filesToDelete" value="" autocomplete="off">
        <input type="hidden" id="filesToExclude" name="filesToExclude" value="0" autocomplete="off">

        <input type="hidden" id="route_redirect" name="route_redirect" value="requirements/view/{{}}" autocomplete="off">

        <div class="columns">

            <div class="column is-2">
                <div class="file is-boxed">
                    <label class="file-label">
                    <input
                        class="file-input"
                        type="file"
                        name="dosyalar[]"
                        id="fupload"
                        multiple
                        onchange="getNames()" />
                    <span class="file-cta">
                        <span class="file-icon">
                            <x-carbon-document-multiple-02 />
                        </span>
                        <span class="file-label">Files</span>
                    </span>
                    </label>
                </div>


            </div>

            <div class="column">
                <table class="table is-striped is-fullwidth" >

                    <caption id="non_selected">No selected files yet!</caption>
                    <tbody id="filesList">
                    </tbody>


                </table>
            </div>

        </div>

        <div id="upButton" class="mt-2 is-hidden">

            <button type="submit" class="button has-background-black has-text-white is-fullwidth">
                <span class="icon"><x-carbon-upload /></span>
                <span>Upload</span>
            </button>
        </div>

        @error('dosyalar') <span class="error">{{ $message }}</span> @enderror

    </form>

</div> --}}

{{-- @php
    print_r($requirement->attachments)
@endphp --}}



<div class="column">
<div class="columns">

    <div class="column is-10">
    <strong>Attachments</strong>


    @if (count($requirement->attachments) > 0)

    <table class="table is-fullwidth">

        @foreach ($requirement->attachments as $attachment)

        <tr>
            <td><a href="/">{{ $attachment->original_file_name }}</a></td>
            <td>{{ $attachment->file_size }}</td>
            <td><a href="/"><span class="icon has-text-danger"><x-carbon-trash-can /></span></a></td>
        </tr>
        @endforeach

    </table>
        
    @endif

    


    </div>

    <div class="column has-text-right is-2">
    <a href="/"><span class="icon has-text-link"><x-carbon-document-attachment /></span></a>
    </div>

</div>
</div>