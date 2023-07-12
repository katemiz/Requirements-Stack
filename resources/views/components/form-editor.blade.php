<div class="field">
    <input type="hidden" name="editor_data" id="ckeditor" value="ttttt">
  
    <label class="label">Requirement Description</label>
    <div class="control">
      <textarea class="textarea" id="editor" placeholder="Textarea"></textarea>
    </div>
  
  
    <script>
        ClassicEditor
          .create( document.querySelector('#editor') )
          .then( editor => {
          // console.log(editor);
          let icerik = document.getElementById('ckeditor').value
      
          if (icerik.length>0) {
            editor.setData(icerik)
          }
      
          editor.model.document.on('change:data', ( evt, data ) => {
          document.getElementById("ckeditor").value = editor.getData()
        });
        })
        .catch( error => {
          console.error(error);
        });
      </script>
  
  
  
  
  </div>
  