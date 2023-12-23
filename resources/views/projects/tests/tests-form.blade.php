<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? $constants['update']['subtitle'] : $constants['create']['subtitle'] }}</h2>
    </header>

    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label class="label">Select Test Type</label>
            <div class="control">
                @foreach ($test_types as $abbr => $tip_name)
                <label class="radio">
                    <input type="radio" value="{{$abbr}}" wire:model="test_type">
                    {{$tip_name}}
                    </label>
                @endforeach
            </div>

            @error('test_type')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


        <div class="field ">
            <div class="field-body">


                @if ($is_user_admin)
                <div class="field">
                    <label class="label">Company</label>
                    <div class="control">
                        <div class="select">
                        <select wire:model='company_id' wire:change='getProjectsList'>
                            <option>Select a company...</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                        </select>
                        </div>
                    </div>

                    @error('company_id')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                @endif


                <div class="field">
                    <label class="label">Project</label>
                    <div class="control">
                        <div class="select">
                        <select wire:model='project_id' wire:change='getEndProductsList'>
                            <option>Select a project...</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                        </select>
                        </div>
                    </div>

                    @error('company_id')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">End Product</label>
                    <div class="control">

                        @if (count($project_eproducts) > 0)

                        <div class="select">

                            <select wire:model='endproduct_id'>
                                <option>Select a End Product...</option>
                                    @foreach ($project_eproducts as $endproduct)
                                        <option value="{{ $endproduct->id }}">{{ $endproduct->title }}</option>
                                    @endforeach
                            </select>

                        </div>

                        @else
                            <p>No end product found</p>
                        @endif
                    </div>

                    @error('endproduct_id')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>




        <div class="field">
            <label class="label">Test Title</label>
            <div class="control">
                <input class="input" type="text" wire:model='title' placeholder="Test title/description ...">
            </div>

            @error('title')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror

        </div>









        <livewire:ck-editor
            wire:model="remarks"
            label='Test Description'
            placeholder='What will be tested ....'
            :content="$remarks"/>

        @error('remarks')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror









        <div class="field block">
            <label class="label">Test Procedure and Support Files</label>

            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Test',
                'modelId' => $uid,
                'tag' => 'procedure',                          // Any tag other than model name
            ])

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'Test',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'procedure'                         // Any tag other than model name
                ])
            </div>
        </div>























        <div class="buttons is-right">
            <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
                @if ($uid)
                    {{ $constants['update']['submitText'] }}
                @else
                    {{ $constants['create']['submitText'] }}
                @endif
            </button>
        </div>




    </form>

    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}


</section>
