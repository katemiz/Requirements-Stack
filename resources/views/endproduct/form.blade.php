<x-layout>
<section class="section container">


    <div class="columns">
        <div class="column"><x-title :params="$params[$action]" /></div>
        <div class="column is-one"><x-info :info="$definition" /></div>
    </div>

    <form action="{{ $params[$action]['submitRoute'] }}" method="POST" enctype="multipart/form-data">
    @csrf

        <x-select :params="$params['form']['project']" />
        <x-form-input :params="$params['form']['code']" />
        <x-form-input :params="$params['form']['title']" />

        <div class="buttons is-right">
            <button class="button is-dark">{{ $params[$action]['submitText'] }}</button>
        </div>

    </form>

</section>
</x-layout>
