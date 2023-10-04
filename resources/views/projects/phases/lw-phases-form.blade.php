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

        <label class="label">Project Phase Code</label>
        <div class="control">

            <input
                class="input"
                wire:model="code"
                type="text"
                placeholder="Enter project phase code (eg P1, M1) ..." required>
        </div>

        @error('code')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="field">

        <label class="label">Project Phase Title</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter project phase (eg Feasibility Phase) ..." required>
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
    
    