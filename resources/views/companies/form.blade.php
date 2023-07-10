<x-layout>
<section class="section container">

    <x-title :params="$params[$action]" />

    <form action="{{ $params[$action]['submitRoute'] }}" method="POST" enctype="multipart/form-data">
    @csrf

        <x-form-input :params="$params['form']['name']" />
        <x-form-input :params="$params['form']['fullname']" />

        <div class="buttons is-right">
            <button class="button is-dark">{{ $params[$action]['submitText'] }}</button>
        </div>

    </form>

</section>
</x-layout>
