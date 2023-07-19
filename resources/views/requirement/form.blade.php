<x-layout>
<section class="section container">

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>


    <x-title :params="config('requirements')[$action]" />

    <form action="{{ config('requirements.cu_route') }}{{ $requirement ? $requirement->id : '' }}" method="POST" enctype="multipart/form-data">
    @csrf


        @php
            print_r(config('requirements.form.endproduct'));
        @endphp
        <x-select :params="config('requirements.form.project')" value="{{ $requirement ? $requirement->project_id : '' }}"/>
        <x-checkbox :params="config('requirements.form.endproduct')" value="{{ $requirement ? $requirement->project_id : '' }}"/>
        <x-select :params="config('requirements.form.rtype')" value="{{ $requirement ? $requirement->rtype : '' }}"/>
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
</x-layout>
