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
                    <a href="/requirements/form" class="button is-dark">
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
                        {{-- <span class="icon is-small"><x-carbon-search-advanced /></span> --}}

                        @if ( strlen($query) > 0)
                            <span class="icon is-small is-left" wire:click="resetFilter">
                                <x-carbon-close />
                            </span>
                        @else
                            <span class="icon is-small" wire:click="$toggle('advanced_search')"><x-carbon-search /></span>
                        @endif
                    </a>
                </div>

            </div>

        </div>

    </nav>

    @if ($advanced_search)

        <div class="column has-text-centered">
            <p class="subtitle">Advanced Search Parameters</p>
        </div>

        <div class="my-6 columns has-background-light">



            <div class="column">

                <label class="label">Filter By Requirement Type</label>

                <div class="select">

                    <select wire:model.live='rtype'>
                        <option>Select Requirement Type ...</option>
                        @foreach ($rtypes as $abbr => $tip_name)
                            <option value="{{ $abbr }}">{{ $tip_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            @if ($project_eproducts->count() > 0)

            <div class="column">

                <label class="label">Filter By End Product</label>

                <div class="select">

                    <select wire:model.live='ep_filter'>
                        <option>Select End Product ...</option>
                        @foreach ($project_eproducts as $ep)
                            <option value="{{ $ep->id }}">{{ $ep->code }}-{{ $ep->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif




            @if (count($chapters) > 0)
            <div class="column">

                <label class="label">Filter By Subject Chapter</label>

                <div class="select">

                    <select wire:model.live='chapter_id'>
                        <option>Select Chapter...</option>
                        @foreach ($chapters as $chapters)
                            <option value="{{ $chapters->id }}">{{ $chapters->title }}</option>
                        @endforeach
                    </select>

                </div>

            </div>
            @endif






        </div>

    @endif

    @if ($requirements->count() > 0)
    <table class="table is-fullwidth">

        <caption>{{ $requirements->total() }} {{ $requirements->total() > 1 ? ' Requirements' :' Requirement' }}</caption>

        @if ($constants['list']['listCaption'])
            <caption>{{ $constants['list']['listCaption'] }}</caption>
        @endif

        <thead>
            <tr>
                @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                    <th class="{{ $headerParams['class'] ? $headerParams['class'] :''}}">
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

            @foreach ($requirements as $record)
            <tr wire:key="{{ $record->id }}">

                @foreach (array_keys($constants['list']['headers']) as $col_name)
                    <td class="{{ $col_name == 'requirement_no' ? 'is-narrow' :'' }}">

                        @if ( $col_name == 'requirement_no' )

                            <a href="/requirements/view/{{ $record->id }}" target="_blank">
                                {{ 'R'.$record->requirement_no.' R'.$record->revision }}
                            </a>

                        @else

                            @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                                <div class="content">{!! $record[$col_name] !!}</div>
                            @else
                                {{ $record[$col_name] }}
                            @endif

                        @endif

                    </td>
                @endforeach

                <td class="has-text-right">

                    <a wire:click="viewItem({{ $record->id }})">
                        <span class="icon"><x-carbon-view/></span>
                    </a>

                    @role(['admin','company_admin','requirement_engineer'])
                        <a href="/requirements/form/{{ $record->id }}">
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    @endrole

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $requirements->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">{{ $constants['list']['noitem'] }}</div>
    @endif
</section>


