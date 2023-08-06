<x-layout>
  <script>

    function deleteConfirm (rid,id) {

      rid = parseInt(rid)
      id = parseInt(id)

      let title,text,redirect

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

    function toggleModal() {
      console.log(document.getElementById('amodal').classList)
      document.getElementById('amodal').classList.add('is-active');
    }

  </script>

  <section class="section container">

    <x-title :params="config('requirements')[$action]" />

    <div class="box">
    <div class="column">
    <div class="columns is-vcentered">

      <div class="column is-8">
        <p class="title has-text-weight-light is-size-2">{{ $requirement->rtype }}-{{ $requirement->id }}</p>
        <p class="subtitle has-text-weight-light is-size-6">Source Requirement No  {{ $requirement['cross_ref_no'] }}</p>
      </div>

      <div class="column has-text-right is-4">
        <a href="/"><span class="icon has-text-link"><x-carbon-list /></span></a>
        <a href="/"><span class="icon has-text-link"><x-carbon-edit /></span></a>
        <a href="/"><span class="icon has-text-danger"><x-carbon-trash-can /></span></a>
      </div>

    </div>
    </div>

    <div class="column">
    <div class="columns is-vcentered">

      <div class="column is-half">
        <p class="has-text-weight-light is-size-6">Project</p>
        <span class="tag is-black">PVR</span>
      </div>

      <div class="column is-half has-text-right">
        <p class="has-text-weight-light is-size-6">End Products</p>

        @foreach ($requirement->endproducts as $ep)
        <span class="tag is-success">{{ $ep->code}}</span>
        @endforeach

      </div>

    </div>
    </div>

    {{-- DESCRIPTION --}}
    <div class="column">
      <p>{!! $requirement['text'] !!}</p>

      @if ( !empty($requirement['remarks']) )
      <p class="has-text-weight-light has-text-grey mb-4 is-size-6">Notes and Remarks</p>
      <p>{!! $requirement['remarks'] !!}</p>
      @endif
    </div>

    {{-- ATTACHMENTS --}}
    <x-attach :requirement="$requirement"/>


    {{-- VERIFICATIONS --}}
    <div class="column">
    <div class="columns is-vcentered">
  
      <div class="column is-10">
        <strong>Verifications</strong>
      </div>

      <div class="column has-text-right is-2">
        <a href="/"><span class="icon has-text-link"><x-carbon-add-alt /></span></a>
      </div>
  
    </div>
    </div>

    <div class="column">
      @if ( count($requirement->verifications) > 0 )

        <table class="table is-fullwidth">
        {{-- <caption>Requirement Verification Table</caption> --}}

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
                  <a href="/requirements/verform/{{ $requirement->id}}/{{ $verification->id}}">
                    <span class="icon has-text-link"><x-carbon-pen /></span>
                  </a>
                  <a href="javascript:deleteConfirm('{{$requirement->id}}','{{$verification->id}}')">
                    <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                  </a>
                </td>
                @endcan
              </tr>

            @endforeach

        </tbody>
        </table>

      @else
        No verifications exist
      @endif
    </div>

    </div>


























    <x-date-by :item="$requirement" />
    {{-- <x-attach-modal /> --}}

  </section>
</x-layout>
