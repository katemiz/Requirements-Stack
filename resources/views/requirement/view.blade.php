<x-layout>
  <script>

    function confirmDelete(id) {

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

            @if ( !empty($requirement['verifications']) )
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
                            <td>Administration </td>
                            <td>{{ $verification->dgate }}</td>
                            <td>Analysis / Design</td>
                            <td>CMP</td>

                            <td>
                            <a href="/verform/1/76">Edit</a> |
                            <a href="/delver/1/76">Delete</a>
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

            <a href="javascript:confirmDelete('{{ $requirement->id}}')" class="card-footer-item">
                <span class="icon has-text-danger-dark"><x-carbon-close-outline /></span>
            </a>
        </footer>
    </div>


  </section>
</x-layout>
