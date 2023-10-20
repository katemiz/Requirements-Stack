<section class="section container">

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>
    <x-title :params="$uid ? $constants['update'] : $constants['create']" />


    <form method="POST" enctype="multipart/form-data">
        @csrf


        <div class="field">
            <label class="label">Select Requirement Type</label>
            <div class="control">
                @foreach ($rtypes as $abbr => $tip_name)
                <label class="radio">
                    <input type="radio" value="{{$abbr}}" wire:model="rtype">
                    {{$tip_name}}
                    </label>
                @endforeach
            </div>
        
            @error('rtype')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


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
    







{{-- 
        <x-select :params="config('requirements.form.rtype')" value="{{ $requirement ? $requirement->rtype : '' }}"/>
        <x-form-input :params="config('requirements.form.cross_ref_no')" value="{{ $requirement ? $requirement->cross_ref_no : '' }}"/>
        <x-form-editor :params="config('requirements.form.text')" value="{{ $requirement ? $requirement->text : '' }}" />
        <x-form-editor :params="config('requirements.form.remarks')" value="{{ $requirement ? $requirement->remarks : '' }}"/> --}}


        {{-- <div class="buttons is-right">
            <button class="button is-dark">{{ config('requirements')[$action]['submitText'] }}</button>
        </div> --}}


        <livewire:ck-editor
            edId="ed10"
            wire:model="text"
            label='Requirement Text / Description'
            placeholder='Detailed description ....'
            :content="$text"/>

        @error('description')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

        <livewire:ck-editor
            edId="ed20"
            wire:model="remarks"
            label='Remarks'
            placeholder='Detailed description ....'
            :content="$remarks"/>

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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


</section>
