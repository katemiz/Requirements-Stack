<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Tests</h1>
    <h2 class="subtitle has-text-weight-light">View Test Attributes</h2>
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
                    <a href="/projects-tests/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                <p class="level-item">
                    <a href="/projects-tests/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a>
                </p>

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','company_admin','requirement_engineer'])

                @if ($status == 'Frozen')

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @else

                    <p class="level-item">
                        <a href='/projects-tests/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click="triggerDelete('test',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                @endif


                @endrole

            </div>
        </nav>

        <div class="column">
            <div class="columns">

                <div class="column is-9">
                    <p class="title has-text-weight-light is-size-2">T{{$test_no}} R{{$revision}}</p>
                    <p class="subtitle has-text-weight-light is-size-6">{{$title}}</p>

                    @if (count($all_revs) > 1)
                    <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                        <ul>
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                            <li><a href="/projects-tests/view/{{$revId}}">R{{$key}}</a></li>
                            @endif
                        @endforeach
                        </ul>
                    </nav>
                    @endif
                </div>

                <div class="column has-text-right is-3">
                    <span class="has-text-weight-bold is-block">Test Type</span>
                    <span class="tag is-info">{{$test_types[$test_type]}}</span>
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

                <span class="tag is-dark">{{ $the_endproduct ? $the_endproduct->code : '----' }}</span>

              </div>

            </div>
        </div>


        @if (strlen(trim($remarks)) > 0)
        <div class="column content has-text-grey">
            <strong>Test Description / What to test</strong>
            {!! $remarks !!}
        </div>
        @endif


        <div class="column content">
            <strong>Related Requirements</strong>

            <ul>
            @foreach ($requirements as $requirement)
                <li>
                <a href="/requirements/view/{{ $requirement->id }}" target="_blank">R{{ $requirement->requirement_no }} R{{ $requirement->revision }}</a>
                </li>
            @endforeach
            </ul>
        </div>

        <div class="column">
            <strong>Procedure and Support Files</strong>
            @livewire('file-list', [
                'canDelete' => false,
                'model' => 'Test',
                'modelId' => $uid,
                'tag' => 'procedure',                          // Any tag other than model name
            ])
        </div>


















        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-centered">
                <strong>Status</strong>
                <p class="subtitle has-text-weight-light is-size-6">{{$status}}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>
