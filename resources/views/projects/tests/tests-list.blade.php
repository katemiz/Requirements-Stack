<section class="container section">

    <div class="columns">

        <div class="column is-8">

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ $constants['list']['title'] }}</h1>

                @if ( $constants['list']['subtitle'] )
                    <h2 class="subtitle has-text-weight-light">{{ $constants['list']['subtitle'] }}</h2>
                @endif
            </header>

        </div>

        <div class="column has-text-right">
            <input type="checkbox" wire:model="show_latest" wire:click="$toggle('show_latest')"> Show only latest revisions
        </div>

    </div>



    @if(session('message'))
        <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="my-6 level">

        <!-- Left side -->
        <div class="level-left">

            {{-- @role(['admin','company_admin']) --}}
            <div class="level-item has-text-centered">
                    <a href="/projects-tests/form" class="button is-dark">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>{{ $constants['list']['addButton']['text'] }}</span>
                    </a>
                </div>
            {{-- @endrole --}}

        </div>

        <!-- Right side -->
        <div class="level-right">

            <div class="field has-addons">
                <div class="control">
                  <input class="input is-small" type="text" wire:model.live="query" placeholder="Search ...">
                </div>
                <div class="control">
                <a class="button is-link is-light is-small">
                    @if ( strlen($query) > 0)
                        <span class="icon is-small is-left" wire:click="resetFilter">
                            <x-carbon-close />
                        </span>
                    @else
                        <span class="icon is-small"><x-carbon-search /></span>
                    @endif
                </a>
                </div>
            </div>

        </div>

    </nav>

    @if ($tests->count() > 0)
    <table class="table is-fullwidth">

        <caption>{{ $tests->total() }} {{ $tests->total() > 1 ? ' Records' :' Record' }}</caption>

        <thead>
            <tr>
                @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                    <th class="has-text-{{ $headerParams['align'] }}">
                        {{ $headerParams['title'] }}

                        @if ($headerParams['sortable'])

                            <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon has-text-link">
                                    <x-carbon-chevron-sort-up />
                                </span>
                            </a>

                            <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon has-text-link">
                                    <x-carbon-chevron-sort-down />
                                </span>
                            </a>

                        @endif
                    </th>
                @endforeach

                @if ( isset($constants['list']['actions']) )
                    <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>
                @endif

            </tr>
        </thead>

        <tbody>

            @foreach ($tests as $record)
            <tr wire:key="{{ $record->id }}">

                <th class="is-narrow"> {{ 'T'.$record->test_no.' R'.$record->revision }}</td>
                <td>
                    {{ $record->title }}

                    <article class="message">
                        <div class="message-body">
                            {!! Str::limit($record->remarks, 160, ' ... ') !!}
                        </div>
                    </article>
                </td>

                <td>
                    {{ $record->created_at }}
                </td>


                <td class="has-text-right">

                    <a wire:click="viewItem({{ $record->id}})">
                        <span class="icon"><x-carbon-view/></span>
                    </a>

                    @role(['admin','company_admin','requirement_engineer'])
                        <a href="/projects-tests/form/{{ $record->id }}">
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    @endrole

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $tests->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">{{ $constants['list']['noitem'] }}</div>
    @endif
</section>


