<x-layout>
  <script>


    function deleteConfirm (rid,id) {

      rid = parseInt(rid)
      id = parseInt(id)


      let title,text,redirect

      console.log(rid,typeof(id))

      // Requirement delete
      if (rid && id < 1) {

        title = {{ Js::from(config('requirements.list.delete_confirm.question')) }}
        text = {{ Js::from(config('requirements.list.delete_confirm.last_warning')) }},

        redirect = '/requirements/delete/'+rid

        console.log("reg")

      }

      // Verification delete
      if (rid && id > 0) {

        title = {{ Js::from(config('verifications.list.delete_confirm.question')) }}
        text = {{ Js::from(config('verifications.list.delete_confirm.last_warning')) }},

        redirect = '/verifications/delete/'+rid+'/'+id

        console.log("ver")

      }

      confirmDialog(title,text,redirect)
    }



    function confirmDialog(title,text,redirect) {

      Swal.fire({
      title: title,
      text: text,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {

              window.location.href = redirect
          } else {
              return false
          }
      })
    }



    function SILconfirmDelete(id) {

      Swal.fire({
      title: {{ Js::from(config('requirements.list.delete_confirm.question')) }},
      text: {{ Js::from(config('requirements.list.delete_confirm.last_warning')) }},
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {

              window.location.href = '/requirements/delete/'+id
          } else {
              return false
          }
      })
    }




  </script>

  <section class="section container">

    <x-title :params="config('requirements')[$action]" />

    <div class="card">

        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <a href="/requirements"><x-carbon-menu /></a>
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">
                <span>{{ $requirement->rtype }}-{{ $requirement->id }}</span>
                {{-- <span class="has-text-weight-light"> {{ $requirement->id }}</span> --}}
              </p>
              <p class="subtitle is-6">@ {{ $requirement->created_at }}</p>
            </div>

            <div class="media-content">

              <h4 class="subtitle has-text-weight-normal my-0">Project</h4>
              <span class="tag is-black">{{ $requirement->project->code }}</span>
            </div>

            <div class="media-content">

              <h4 class="subtitle has-text-weight-normal my-0">End Products</h4>
              @foreach ($requirement->endproducts as $ep)
              <span class="tag is-info">{{ $ep->code}}</span>
              @endforeach
            </div>


          </div>

          <div class="content">
            <p>{!! $requirement['text'] !!}</p>

            @if ( !empty($requirement['remarks']) )
            <h4 class="subtitle has-text-weight-normal mt-3">Remarks</h4>
            <p>{!! $requirement['remarks'] !!}</p>
            @endif

            <a href="/requirements/verform/{{ $requirement->id}}" class="button is-link is-small" href="/verform/1"> Add Verification</a>

            @if ( count($requirement->verifications) > 0 )
                <h4 class="subtitle has-text-weight-normal mt-3">Verifications</h4>

                <table class="table is-fullwidth">

                <tbody>
                    <tr>
                        <th>Witness</th>
                        <th>Decision Gate</th>
                        <th>Verfifcation Method</th>
                        <th>Proof of Compliance</th>
                        <th>Actions</th>
                    </tr>

                    @foreach ($requirement->verifications as $verification)

                      <tr>
                          <td>{{ $verification->witness->code }}</td>
                          <td>{{ $verification->dgate->code }}</td>
                          <td>{{ $verification->moc->code }}</td>
                          <td>{{ $verification->poc->code }}</td>
                          <td>
                            <a href="/requirements/verform/{{ $requirement->id}}/{{ $verification->id}}">Edit</a> |
                            <a href="javascript:deleteConfirm('{{$requirement->id}}','{{$verification->id}}')">Delete</a>



                          </td>
                      </tr>

                    @endforeach

                </tbody>
                </table>

            @endif

            @if ($requirement->updated_at != $requirement->created_at)
            <div class="is-size-7 has-text-grey-light">
                Updated @ {{ $requirement->updated_at }}
            </div>
            @endif

          </div>
        </div>

        <footer class="card-footer">

            <a href="/requirements/form/{{ $requirement->id}}" class="card-footer-item">
                <span class="icon"><x-carbon-pen/></span>
            </a>

            <a href="javascript:deleteConfirm('{{ $requirement->id}}',0)" class="card-footer-item">
                <span class="icon has-text-danger-dark"><x-carbon-trash-can /></span>
            </a>
        </footer>
    </div>


  </section>
</x-layout>
