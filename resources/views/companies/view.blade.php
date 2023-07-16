<x-layout>
  <script>

    function confirmDelete(id) {

      Swal.fire({
      title: {{ Js::from(config('companies')['list']['delete_confirm']['question']) }},
      text: {{ Js::from(config('companies')['list']['delete_confirm']['last_warning']) }},
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete',
      cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {

              window.location.href = '/companies/delete/'+id
          } else {
              return false
          }
      })
    }

  </script>

  <section class="section container">
      
    <x-title :params="config('companies')[$action]" />

    <div class="card">

        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <a href="/companies"><x-carbon-menu /></a>
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">{{ $company['name'] }}</p>
              <p class="subtitle is-6">@ {{ $company['created_at'] }}</p>
            </div>
          </div>
      
          <div class="content">
            <p>{{ $company['fullname'] }}</p>

            @if ($company['updated_at'] != $company['created_at'])
            <div class="is-size-7 has-text-grey-light">
                Updated @ {{ $company['created_at'] }}
            </div>
            @endif

          </div>
        </div>

        <footer class="card-footer">
            <a href="/companies/form/{{ $company->id}}" class="card-footer-item">
                <span class="icon"><x-carbon-pen/></span>
            </a>

            <a href="javascript:confirmDelete('{{ $company->id}}')" class="card-footer-item">
                <span class="icon"><x-carbon-close-outline /></span>
            </a>
        </footer>
    </div>
  
  </section>
</x-layout>
    