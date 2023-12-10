<script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>


<x-title :params="$uid ? $constants['update'] : $constants['create']" />


<form method="POST" enctype="multipart/form-data">
    @csrf


    <div class="field ">
        <div class="field-body">

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
        
            <div class="field">
                <label class="label">Project</label>
                <div class="control">
                    <div class="select">
                    <select wire:model='project_id'>
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

        </div>
    </div>


    <div class="field">

        <label class="label">End Product Code</label>
        <div class="control">

            <input
                class="input"
                wire:model="code"
                type="text"
                placeholder="Enter project end product code (eg SSA) ..." required>
        </div>

        @error('code')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="field">

        <label class="label">End Product Title</label>
        <div class="control">

            <input
                class="input"
                wire:model="title"
                type="text"
                placeholder="Enter End Product title (eg Side Section Assembly) ..." required>
        </div>

        @error('title')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>




    <livewire:ck-editor
        wire:model="description"
        label='Description'
        placeholder='Detailed description ....'
        :content="$description"/>

    @error('description')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror










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
    
    