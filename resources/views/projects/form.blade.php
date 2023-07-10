<x-layout>
<section class="section container">

    <x-title :params="$params[$action]" />

    <form action="{{ $params[$action]['submitRoute'] }}" method="POST" enctype="multipart/form-data">
    @csrf

        <x-select :params="$params['form']['company']" />
        <x-form-input :params="$params['form']['code']" />
        <x-form-input :params="$params['form']['title']" />

        <div class="buttons is-right">
            <button class="button is-dark">{{ $params[$action]['submitText'] }}</button>
        </div>

    </form>

</section>
</x-layout>
