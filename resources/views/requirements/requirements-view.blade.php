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
                    <p class="title has-text-weight-light is-size-2">R{{$requirement_no}} R{{$revision}}</p>
                    <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong> {{$status}}</p>

                    @if (count($all_revs) > 1)
                    <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                        <ul>
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                            <li><a href="/requirements/view/{{$revId}}">R{{$key}}</a></li>
                            @endif
                        @endforeach
                        </ul>
                    </nav>
                    @endif
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

                @foreach ($project_eproducts as $ep)
                    @if ( in_array($ep->id,$endproduct_ids) )
                        <span class="tag is-dark">{{ $ep->code }}</span>
                    @endif
                @endforeach

              </div>

            </div>
        </div>


        @if ( $rtype === 'DEF')
        <div class="column">
            <strong>Title</strong>
            <p>{{ $title }}</p>
        </div>
        @endif


        @if ($chapter_id)
        <div class="column">
            <strong>Chapter Requirements Belongs To</strong>
            <p>{{ $chapter->title }}</p>
        </div>
        @endif



        <div class="column">
            <div class="content">
            <strong>Requirement Text</strong>
            {!! $text !!}
            </div>
        </div>


        <div class="column">
            <strong>Attachments</strong>
            @livewire('file-list', [
                'canDelete' => false,
                'model' => 'Requirement',
                'modelId' => $uid,
                'tag' => 'support',                          // Any tag other than model name
            ])
        </div>



        @if (strlen(trim($remarks)) > 0)
        <div class="column content has-text-grey">
            <strong>Remarks/Notes</strong>
            {!! $remarks !!}
        </div>
        @endif


        @if ( $rtype != 'DEF')

            {{-- VERIFICATIONS --}}
            <div class="column">
                <div class="columns is-vcentered">

                    <div class="column is-10">
                        <strong>Verifications</strong>
                    </div>

                    <div class="column has-text-right is-2">
                        @if ($status != 'Frozen')
                        @role(['admin','company_admin','requirement_engineer'])
                        <a href="/verifications/{{$uid}}/form" class="button is-link is-small">
                            <span class="icon is-small">
                                <x-carbon-add />
                            </span>
                            <span>Add</span>
                        </a>
                        @endrole
                        @endif
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
                        @if ($status != 'Frozen')
                            @role(['admin','company_admin','requirement_engineer'])
                            <th>Actions</th>
                            @endrole
                        @endif
                    </tr>

                    @foreach ($verifications as $verification)
                        <tr>
                        <td><abbr title="{{ $verification->dgate->name }}">{{ $verification->dgate->code }}</abbr></td>
                        <td><abbr title="{{ $verification->moc->name }}">{{ $verification->moc->code }}</abbr></td>
                        <td><abbr title="{{ $verification->poc->name }}">{{ $verification->poc->code }}</abbr></td>
                        <td>{{ $verification->witness->code }}</td>
                        <td class="is-size-7">{!! $verification->remarks !!}</td>
                        @if ($status != 'Frozen')
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
                        @endif

                        </tr>
                    @endforeach

                </tbody>
                </table>

                @else
                No verifications exist
                @endif
            </div>


            <div class="column">
                <strong class="mb-3">Related Tests</strong>
                @if ( count($requirement_tests) > 0 )
                    @foreach ($requirement_tests as $idTest)

                        @foreach ($tests as $test)
                            @if ($idTest == $test->id)
                            <div>
                                <a href="/projects-tests/view/{{ $test->id }}">T{{ $test->test_no }} R{{ $test->revision }}</a>
                                {{ $test->title }}
                            </div>
                            @endif
                        @endforeach

                    @endforeach
                @else
                <p>No related test</p>
                @endif
            </div>

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


        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <a wire:click="getPreviousNextRequirement('previous')">
                    <span class="icon"><x-carbon-previous-filled /></span>
                </a>
            </div>

            <div class="column has-text-right">
                <a wire:click="getPreviousNextRequirement('next')">
                    <span class="icon"><x-carbon-next-filled /></span>
                </a>
            </div>

        </div>

    </div>

</div>
