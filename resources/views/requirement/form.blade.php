<x-layout>
<section class="section container">

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>


    <x-title :params="$params[$action]" />

    <form action="{{ $params[$action]['submitRoute'] }}" method="POST" enctype="multipart/form-data">
    @csrf

        {{-- <pre>
        @php
            print_r($params['form']['text']);
        @endphp
        </pre> --}}

        <x-select :params="$params['form']['project']" />
        <x-form-editor :params="$params['form']['text']"/>
        <x-form-editor :params="$params['form']['remarks']"/>


        <div class="buttons is-right">
            <button class="button is-dark">{{ $params[$action]['submitText'] }}</button>
        </div>

    </form>




</section>
</x-layout>
