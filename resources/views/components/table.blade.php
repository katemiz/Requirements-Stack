<div>

    <script>
        window.addEventListener('jsConfirmDelete', event => {

            let id = event.detail.id
        
            Swal.fire({
                title: {{ Js::from($params['delete_confirm']['question']) }},
                text: {{ Js::from($params['delete_confirm']['last_warning']) }},
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('delete', id)
                } else {
                    return false
                }
            })
        })    

        window.addEventListener('informUserOnDelete', event => {

            let id = event.detail.id
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Record has been successfully deleted',
                showConfirmButton: false,
                timer: 1500
            })
        }) 
    </script>

    <table class="table is-fullwidth">

        @if ($params['listCaption'])
            <caption>{{ $params['listCaption'] }}</caption>
        @endif

        <thead>
            <tr>
                @foreach ($params['headers'] as $col_name => $headerParams)
                    <th class="has-text-{{ $headerParams['align'] }}">
                        {{ $headerParams['title'] }}

                        @if ($headerParams['sortable'])

                            <button class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon">
                                    <x-carbon-chevron-sort-up />
                                </span>
                            </button>

                            <button class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon">
                                    <x-carbon-chevron-sort-down />
                                </span>
                            </button>
                            
                        @endif
                    </th>
                @endforeach

                @if ( isset($params['actions']) )
                    <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>
                @endif

            </tr>
        </thead>

        <tbody>

            @foreach ($records as $record)
            <tr>

                @foreach (array_keys($params['headers']) as $col_name)
                <td>{{ $record[$col_name] }}</td>                
                @endforeach

                @if ( isset($params['actions']) )
                <td class="has-text-right">
                    @foreach ($params['actions'] as $act => $route)

                        @switch($act)
                            @case('r')
                                <a href="{{ $route }}{{ $record->id}}">
                                <span class="icon"><x-carbon-view/></span>   
                                </a>                           
                                @break
                            @case('w')
                                <a href="{{ $route }}{{ $record->id}}">
                                <span class="icon"><x-carbon-pen/></span>   
                                </a>                                                    
                                @break
                            @case('x')
                                <a wire:click.prevent="deleteConfirm({{$record->id}})">
                                <span class="icon has-text-danger-dark"><x-carbon-close/></span>   
                                </a>                                                   
                                @break
                        @endswitch
                        
                    @endforeach
                </td>
                @endif

            </tr>
            @endforeach



        </tbody>
    </table>

</div>