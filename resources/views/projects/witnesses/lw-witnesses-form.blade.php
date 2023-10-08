<x-title :params="$uid ? $constants['update'] : $constants['create']" />


<form method="POST" enctype="multipart/form-data">
    @csrf



    <div class="field">
        <label class="label">Company</label>
        <div class="control">
            <div class="select">
            <select wire:model='company_id' wire:change='getProjects'>
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



    <div class="field">
        <label class="label">Projects</label>
        <div class="control">
            <div class="select">
            <select wire:model='project_id' wire:change='getProjects'>
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
        <label class="label">End Products</label>
        <div class="control">

            @if ($project_id && count($project_eproducts[$project_id]) > 0)

            <div class="select">

                <select wire:model='endproduct_id'>
                    <option>Select a End Product...</option>
                        @foreach ($project_eproducts[$project_id] as $endproduct)
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





    <div class="field">

        <label class="label">Project Witnesss Code</label>
        <div class="control">

            <input
                class="input"
                wire:model="code"
                type="text"
                placeholder="Enter Project Witnesss code (eg Company or individual) ..." required>
        </div>

        @error('code')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="field">

        <label class="label">Project Witnesss Name/Title</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter Project Witnesss Name/Title (eg Compnat or Individual Fullname) ..." required>
        </div>

        @error('name')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
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
    
    