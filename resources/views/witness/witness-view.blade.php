<x-layout>
  <script>

    function confirmDelete(id) {

      Swal.fire({
      title: {{ Js::from(config('witnesses.list.delete_confirm.question')) }},
      text: {{ Js::from(config('witnesses.list.delete_confirm.last_warning')) }},
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {

              window.location.href = '/witness/delete/'+id
          } else {
              return false
          }
      })
    }

  </script>

  <section class="section container">

    <x-title :params="config('witnesses')[$action]" />

    <div class="card">

        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <a href="/witness"><x-carbon-menu /></a>
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">
                <span>{{ $witness->company_name }}</span>
                <span class="has-text-weight-light"> {{ $witness->code }}</span>
              </p>
              <p class="subtitle is-6">@ {{ $witness->created_at }}</p>
            </div>
          </div>

          <div class="content">
            <p>{{ $witness['name'] }}</p>

            @if ($witness->updated_at != $witness->created_at)
            <div class="is-size-7 has-text-grey-light">
                Updated @ {{ $witness->updated_at }}
            </div>
            @endif

          </div>
        </div>

        <footer class="card-footer">
            <a href="/witness/form/{{ $witness->id}}" class="card-footer-item">
                <span class="icon"><x-carbon-pen/></span>
            </a>

            <a href="javascript:confirmDelete('{{ $witness->id}}')" class="card-footer-item">
                <span class="icon has-text-danger-dark"><x-carbon-close-outline /></span>
            </a>
        </footer>
    </div>

  </section>
</x-layout>
