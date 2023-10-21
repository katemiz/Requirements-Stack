<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Requirements</h1>
    <h2 class="subtitle has-text-weight-light">Requirement Details and Verifications</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<div class="card">

    <div class="card-content">

        <nav class="level mb-6">
            <!-- Left side -->
            <div class="level-left">
        
                <p class="level-item">
                    <a href="/requirements/list">                    
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>
        
                <p class="level-item">
                    <a href="/requirements/form/">
                        <span class="icon is-small"><x-carbon-add-large /></span>
                        <span>Add</span>
                    </a>
                </p>
        
            </div>
        
            <!-- Right side -->
            <div class="level-right">
        
                <p class="level-item">
                    <a href='/requirements/form/{{ $uid }}'>
                        <span class="icon"><x-carbon-edit /></span>
                    </a>
                </p>
        
                <p class="level-item">
                    <a wire:click='triggerDelete({{ $uid }})'>
                        <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                    </a>
                </p>
        
            </div>
        </nav>




        <div class="column">
            <div class="columns is-vcentered">

                <div class="column is-8">
                    <p class="title has-text-weight-light is-size-2">{{$rtype}}-{{$uid}} </p>
                    <p class="subtitle has-text-weight-light is-size-6">Cross Requirement No {{$xrefno}}</p>
                </div>

                <div class="column has-text-right is-4">
                    <p class="subtitle has-text-weight-light is-size-6">{{ $rtypes[$rtype] }}</p>
                    <p class="subtitle has-text-weight-light is-size-6">{{ $source }}</p>
                </div>

            </div>
        </div>
















        <div class="column">
            <div class="columns is-vcentered">
    
              <div class="column is-half">
                <p class="has-text-weight-light is-size-6">Project</p>
                <span class="tag is-black">{{ $the_project->code }}</span>
              </div>
    
              <div class="column is-half has-text-right">
                <p class="has-text-weight-light is-size-6">End Product</p>
    
                <span class="tag is-success">{{ $the_endproduct->code }}</span>
                
              </div>
    
            </div>
        </div>













        <div class="column">
            <strong>Requirement Text</strong>
            {!! $text !!}
        </div>


        @if (strlen(trim($remarks)) > 0) 
        <div class="column">
            <strong>Attachments</strong>
            {!! $remarks !!}
        </div>
        @endif

        @if (strlen(trim($remarks)) > 0) 
        <div class="column">
            {!! $remarks !!}
        </div>
        @endif





        <div class="column">
            <div class="columns is-vcentered">
    
                <div class="column">
                    <strong>Verifications</strong>
                    {{ $source }}
                </div>
    
                <div class="column is-narrow">

                </div>
    
            </div>
        </div>





        {{-- VERIFICATIONS --}}
        <div class="column">
            @if ( count($requirement->verifications) > 0 )
    
              <table class="table is-fullwidth">
    
              <tbody>
                  <tr>
                      <th>Decision Gate</th>
                      <th>MOC/Verification Method</th>
                      <th>Proof of Compliance</th>
                      <th>Witness</th>
                      @role(config('requirements.roles.w'))
                      <th>Actions</th>
                      @endrole
                  </tr>
    
                  @foreach ($requirement->verifications as $verification)
    
                    <tr>
                      <td>{{ $verification->dgate->code }}</td>
                      <td>{{ $verification->moc->code }}</td>
                      <td>{{ $verification->poc->code }}</td>
                      <td>{{ $verification->witness->code }}</td>
                      @role(config('requirements.roles.w'))
                      <td>
                        <a href="/requirements/verform/{{ $requirement->id}}/{{ $verification->id}}">
                          <span class="icon has-text-link"><x-carbon-pen /></span>
                        </a>
                        <a href="javascript:deleteConfirm('{{$requirement->id}}','{{$verification->id}}')">
                          <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                      </td>
                      @endrole
                    </tr>
    
                  @endforeach
    
              </tbody>
              </table>
    
            @else
              No verifications exist
            @endif
        </div>









        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>
        
            <div class="column has-text-right">
                <p>{{ $updated_by }}</p>
                <p>{{ $updated_at }}</p>
            </div>
        
        </div>
        
    </div>

</div>

