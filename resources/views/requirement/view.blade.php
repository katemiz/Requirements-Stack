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

    function toggleModal() {


        console.log(document.getElementById('amodal').classList)
        document.getElementById('amodal').classList.add('is-active');

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


            @if ( !empty($requirement['cross_ref_no']) )
            <h4 class="subtitle has-text-weight-normal mt-3">Source Requirement No</h4>
            <p>{{ $requirement['cross_ref_no'] }}</p>
            @endif

            @if ( !empty($requirement['remarks']) )
            <h4 class="subtitle has-text-weight-normal mt-3">Remarks</h4>
            <p>{!! $requirement['remarks'] !!}</p>
            @endif

            @can(config('requirements.perms.w'))
            <a href="/requirements/verform/{{ $requirement->id}}" class="button is-link is-small" href="/verform/1"> Add Verification</a>
            @endcan

            @if ( count($requirement->verifications) > 0 )
                <h4 class="subtitle has-text-weight-normal mt-3">Verifications</h4>

                <table class="table is-fullwidth">
                <caption>Requirement Verification Table</caption>

                <tbody>
                    <tr>
                        <th>Decision Gate</th>
                        <th>MOC/Verification Method</th>
                        <th>Proof of Compliance</th>
                        <th>Witness</th>
                        @can(config('requirements.perms.w'))
                        <th>Actions</th>
                        @endcan
                    </tr>

                    @foreach ($requirement->verifications as $verification)

                      <tr>
                        <td>{{ $verification->dgate->code }}</td>
                        <td>{{ $verification->moc->code }}</td>
                        <td>{{ $verification->poc->code }}</td>
                        <td>{{ $verification->witness->code }}</td>
                        @can(config('requirements.perms.w'))
                        <td>
                        <a href="/requirements/verform/{{ $requirement->id}}/{{ $verification->id}}">Edit</a> |
                        <a href="javascript:deleteConfirm('{{$requirement->id}}','{{$verification->id}}')">Delete</a>
                        </td>
                        @endcan
                      </tr>

                    @endforeach

                </tbody>
                </table>

            @endif

          </div>
        </div>

        @can(config('requirements.perms.w'))
        <footer class="card-footer">

            <a href="javascript:toggleModal()" class="card-footer-item">

            {{-- <a href="/add-attach/requirement/{{ $requirement->id}}" class="card-footer-item"> --}}
                <span class="icon"><x-carbon-document-attachment /></span>
            </a>

            <a href="/requirements/form/{{ $requirement->id}}" class="card-footer-item">
                <span class="icon"><x-carbon-edit/></span>
            </a>

            <a href="javascript:deleteConfirm('{{ $requirement->id}}',0)" class="card-footer-item">
                <span class="icon has-text-danger-dark"><x-carbon-trash-can /></span>
            </a>
        </footer>
        @endcan


        <nav class="level m-2">
          <!-- Left side -->
          <div class="level-left">
            @if ($previous)
            <a href="/requirements/view/{{ $previous}}" class="card-footer-item">
              <span class="icon"><x-carbon-chevron-left /></span>
            </a>
            @endif
          </div>

          <!-- Right side -->
          <div class="level-right">
            @if ($next)
            <a href="/requirements/view/{{ $next}}" class="card-footer-item">
              <span class="icon"><x-carbon-chevron-right /></span>
            </a>
            @endif
          </div>
        </nav>








    </div>

    <x-date-by :item="$requirement" />



    <x-attach-modal />


  </section>
</x-layout>
