<x-layout>
  <script>

    function confirmDelete(id) {

      Swal.fire({
      title: {{ Js::from($params['list']['delete_confirm']['question']) }},
      text: {{ Js::from($params['list']['delete_confirm']['last_warning']) }},
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {

              window.location.href = '/projects/delete/'+id
          } else {
              return false
          }
      })
    }

  </script>

  <section class="section container">
      
    <x-title :params="$params[$action]" />

    <div class="card">

        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <a href="/projects"><x-carbon-menu /></a>
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">
                <span>{{ $project['company']['name'] }} </span>
                <span class="has-text-weight-light"> {{ $project['code'] }}</span>
              </p>
              <p class="subtitle is-6">@ {{ $project['created_at'] }}</p>
            </div>
          </div>

          <div class="content">
            <p>{{ $project['title'] }}</p>

            @if ($project['updated_at'] != $project['created_at'])
            <div class="is-size-7 has-text-grey-light">
                Updated @ {{ $project['created_at'] }}
            </div>
            @endif

          </div>
        </div>

        <footer class="card-footer">
            <a href="/projects/form/{{ $project->id}}" class="card-footer-item">
                <span class="icon"><x-carbon-pen/></span>
            </a>

            <a href="javascript:confirmDelete('{{ $project->id}}')" class="card-footer-item">
                <span class="icon has-text-danger-dark"><x-carbon-close-outline /></span>
            </a>
        </footer>
    </div>
  
  </section>
</x-layout>
    