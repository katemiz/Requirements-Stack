
    <section class="section container">

        <script src="{{ asset('/js/attachment.js') }}"></script>


        <x-title :params="$headers" />

    <div class="mb-3">
        <label
          for="formFile"
          class="mb-2 inline-block text-neutral-700"
          >Default file input example</label
        >
        <input
          class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none"
          type="file"
          id="formFile" />
      </div>



      <input type="hidden" id="filesToUpload" value="0" autocomplete="off">
      <input type="hidden" id="filesToDelete" name="filesToDelete" value="" autocomplete="off">
      <input type="hidden" id="filesToExclude" name="filesToExclude" value="0" autocomplete="off">


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

            <div id="upButton" class="file is-boxed mt-2 is-hidden">
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
                        <x-carbon-upload />
                    </span>
                    <span class="file-label">Upload</span>
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






    </section>
