<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Project Milestones/Decision Gates</h1>
    <h2 class="subtitle has-text-weight-light">View Project Milestones/Decision Gates Attributes</h2>
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
                    <a href="/projects-gates/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                @role(['admin','company_admin','requirement_engineer'])
                <p class="level-item">
                    <a href="/projects-gates/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a>
                </p>
                @endrole

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','company_admin','requirement_engineer'])

                <p class="level-item">
                    <a href='/projects-gates/form/{{ $uid }}'>
                        <span class="icon"><x-carbon-edit /></span>
                    </a>
                </p>

                <p class="level-item">
                    <a wire:click='triggerDelete({{ $uid }})'>
                        <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                    </a>
                </p>
                @endrole

            </div>
        </nav>

        <div class="media">
            <div class="media-left has-text-centered">
                <figure class="image is-48x48"><x-carbon-milestone /></figure>
            </div>
            <div class="media-content">
                <p class="title is-4">G-{{ $uid }}</p>
                <p class="subtitle is-6">
                    {{ $code}} - {{ $name}}
                    [
                        <span class="has-text-weight-bold">{{ $the_company->name}}</span>,
                        <span class="has-text-weight-normal">{{ $the_project->code }}-{{ $the_project->title }}</span>
                        <span class="has-text-weignt-light">{{ $the_endproduct ? ', ' .$the_endproduct->title : ''}}</span>
                    ]
                </p>
            </div>
        </div>

        {{-- <div class="column content">
            <strong>Description</strong>
            {!! $description !!}
        </div> --}}

        <div class="column content">
            <strong>Purpose</strong>
            {!! $purpose !!}
        </div>

        <div class="column content">
            <strong>Timing</strong>
            {!! $timing !!}
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

