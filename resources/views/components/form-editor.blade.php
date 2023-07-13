<div class="field">
    <input type="label" name="hidEl{{ $params['name']}}" id="hidElId{{ $params['name']}}" value="">
  
    <label class="label">{{ $params['label'] }}</label>
    <div class="control">
      <textarea class="textarea" id="ck{{ $params['name']}}" placeholder="Textarea"></textarea>
    </div>
  
  
    <script>
        ClassicEditor
          .create( document.querySelector('#ck{{ $params['name']}}') )
          .then( editor => {
          // console.log(editor);
          let icerik = document.getElementById('hidElId{{ $params['name']}}').value
      
          if (icerik.length>0) {
            editor.setData(icerik)
          }
      
          editor.model.document.on('change:data', ( evt, data ) => {
          document.getElementById("ck{{ $params['name']}}").value = editor.getData()
        });
        })
        .catch( error => {
          console.error(error);
        });
      </script>
  
  
  
  
  </div>
  