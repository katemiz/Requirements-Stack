<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Project Phases</h1>
    <h2 class="subtitle has-text-weight-light">View Project Phase Attributes</h2>
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
                    <a href="/projects-phases/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                @role(['admin','company_admin','requirement_engineer'])
                <p class="level-item">
                    <a href="/projects-phases/form/">
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
                    <a href='/projects-phases/form/{{ $uid }}'>
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
                <figure class="image is-48x48"><x-carbon-timer /></figure>
            </div>
            <div class="media-content">
                <p class="title is-4">{{ $code}} </p>
                <p class="subtitle is-6">{{ $name}}</p>
            </div>
        </div>

        <p class="subtitle is-6">
            <span class="has-text-danger-dark">{{ $the_company->name}}</span>
            <span class="has-text-success-dark">{{ $the_project->code }} / {{ $the_project->title }}</span>
            <span class="has-text-weignt-bold">{{ $the_endproduct ? ' - ' .$the_endproduct->title : ''}}</span>
        </p>


        @if (strlen(trim($description)) > 0)
        <p class="subtitle is-6">
            {!! $description !!}
        </p>
        @endif

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

