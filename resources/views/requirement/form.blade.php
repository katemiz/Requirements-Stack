<section class="section container">

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>


    <x-title :params="config('requirements')[$action]" />

    <form action="{{ config('requirements.cu_route') }}{{ $requirement ? $requirement->id : '' }}" method="POST" enctype="multipart/form-data">
    @csrf

{{-- <pre>
        @php
            print_r($projects);
        @endphp
        </pre> --}}


        <div class="field">
            <label class="label">{{ config('requirements.form.project.label') }}</label>
            <div class="control">
              <div class="select">
                <select name="{{ config('requirements.form.project.name') }}">
                  <option value="notselected">Select</option>
        
                  @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected( count($projects) == 1 || $project->id == $value)>{{ $project->code }}</option>
                  @endforeach
        
                </select>
              </div>
            </div>
        
            @error(config('requirements.form.project.name'))
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


        @if ($selectedPrj)

        {{-- @php
            print_r($selectedPrj->endproducts());
        @endphp --}}
            

        <div class="field">
            <label class="label">{{ config('requirements.form.endproduct.label') }}</label>
            <div class="control">
              <div class="select">
                <select name="{{ config('requirements.form.endproduct.name') }}">
                  <option value="notselected">Select</option>
        
                  @foreach ($selectedPrj->endproducts() as $endproduct)
                    <option value="{{ $endproduct->id }}" @selected( count($projects) == 1 || $endproduct->id == $value)>{{ $endproduct->code }}</option>
                  @endforeach
        
                </select>
              </div>
            </div>
        
            @error(config('requirements.form.endproduct.name'))
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>

        @else 

        <p>{{ config('requirements.form.endproduct.nooptions') }}</p>

        @endif

















        {{-- <x-select :params="config('requirements.form.project')" value="{{ $requirement ? $requirement->project_id : '' }}"/> --}}
        {{-- <x-checkbox :params="config('requirements.form.endproduct')" value="{{ $requirement ? $requirement->project_id : '' }}"/> --}}
        {{-- <x-select :params="config('requirements.form.rtype')" value="{{ $requirement ? $requirement->rtype : '' }}"/> --}}
        <x-form-input :params="config('requirements.form.cross_ref_no')" value="{{ $requirement ? $requirement->cross_ref_no : '' }}"/>
        <x-form-editor :params="config('requirements.form.text')" value="{{ $requirement ? $requirement->text : '' }}" />
        <x-form-editor :params="config('requirements.form.remarks')" value="{{ $requirement ? $requirement->remarks : '' }}"/>

        <div class="buttons is-right">
            <button class="button is-dark">{{ config('requirements')[$action]['submitText'] }}</button>
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
