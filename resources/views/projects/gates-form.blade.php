<x-layout>
    <section class="section container">

        <x-title :params="config('dgates')[$action]" />

        <form action="{{ config('dgates.cu_route') }}{{ $dgate ? $dgate->id : ''}}" method="POST" enctype="multipart/form-data">
        @csrf

            {{-- <x-select :params="config('dgates.form.company')" value="{{ $dgate ? $dgate->company_id : '' }}"/> --}}
            <x-form-input :params="config('dgates.form.code')" value="{{ $dgate ? $dgate->code : '' }}"/>
            <x-form-input :params="config('dgates.form.title')" value="{{ $dgate ? $dgate->title : '' }}"/>

            <div class="buttons is-right">
                <button class="button is-dark">{{ config('dgates')[$action]['submitText'] }}</button>
            </div>

        </form>

    </section>
    </x-layout>
