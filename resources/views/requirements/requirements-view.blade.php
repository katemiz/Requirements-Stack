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

                @role(['admin','company_admin','requirement_engineer'])

                @if ($status == 'Frozen')

                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>

                @else
                    
                    <p class="level-item">
                        <a href='/requirements/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click="triggerDelete('requirement',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                @endif


                @endrole

            </div>
        </nav>

        <div class="column">
            <div class="columns">

                <div class="column is-8">
                    <p class="title has-text-weight-light is-size-2">{{$rtype}}-{{$requirement_no}} R{{$revision}}</p>
                    <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong> {{$status}}</p>
                </div>

                <div class="column has-text-right is-4">


                    <table class="table is-fullwidth">
                        <tr>
                            <th>Requirement Type</th>
                            <td>{{$rtypes[$rtype]}}</td>
                        </tr>
                        <tr>
                            <th>Requirement Source</th>
                            <td>{{$source}}</td>
                        </tr>
                        <tr>
                            <th>Cross Ref No</th>
                            <td>{{$xrefno}}</td>
                        </tr>
                    </table>
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

                <span class="tag is-success">{{ $endproduct_id > 0 ? $the_endproduct->code : '----' }}</span>

              </div>

            </div>
        </div>


        <div class="column">
            <strong>Requirement Text</strong>
            {!! $text !!}
        </div>


        {{-- @if (strlen(trim($remarks)) > 0)
        <div class="column">
            <strong>Attachments</strong>
            {!! $remarks !!}
        </div>
        @endif --}}

        @if (strlen(trim($remarks)) > 0)
        <div class="column">
            {!! $remarks !!}
        </div>
        @endif


        {{-- VERIFICATIONS --}}
        <div class="column">
            <div class="columns is-vcentered">

                <div class="column is-10">
                    <strong>Verifications</strong>
                </div>

                <div class="column has-text-right is-2">
                    @role(['admin','company_admin','requirement_engineer'])
                    <a href="/verifications/{{$uid}}/form" class="button is-link is-small">
                        <span class="icon is-small">
                            <x-carbon-add />
                        </span>
                        <span>Add</span>
                    </a>
                    @endrole
                </div>

            </div>
        </div>


        <div class="column">
            @if ( count($verifications) > 0 )

              <table class="table is-fullwidth">

              <tbody>
                  <tr>
                      <th>Decision Gate</th>
                      <th>MOC/Verification Method</th>
                      <th>Proof of Compliance</th>
                      <th>Witness</th>
                      <th>Remarks</th>
                      @role(['admin','company_admin','requirement_engineer'])
                      <th>Actions</th>
                      @endrole
                  </tr>

                  @foreach ($verifications as $verification)
                    <tr>
                      <td><abbr title="{{ $verification->dgate->name }}">{{ $verification->dgate->code }}</abbr></td>
                      <td><abbr title="{{ $verification->moc->name }}">{{ $verification->moc->code }}</abbr></td>
                      <td><abbr title="{{ $verification->poc->name }}">{{ $verification->poc->code }}</abbr></td>
                      <td>{{ $verification->witness->code }}</td>
                      <td class="is-size-7">{!! $verification->remarks !!}</td>
                      @role(['admin','company_admin','requirement_engineer'])
                      <td>
                        <a href="/verifications/{{ $uid}}/form/{{ $verification->id}}">
                          <span class="icon has-text-link"><x-carbon-pen /></span>
                        </a>
                        <a wire:click="triggerDelete('verification',{{ $verification->id }})">

                        {{-- <a wire:click="triggerDelete('verification',{{ $verification->id }})"> --}}
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
