<section class="section container">

    <div class="columns">
        <div class="column"><x-title :params="$params['list']" /></div>
        <div class="column is-one"><x-info :info="config('definitions.endproduct')" /></div>
    </div>
    
    <x-table-action :params="$params['list']" />

    @if ($records->count() > 0)

        <x-table :params="$params['list']" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ $params['list']['noitem'] }}" />
    @endif

</section>
