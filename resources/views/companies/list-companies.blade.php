<section class="section container">

    <x-title :params="$params['list']" />
    <x-table-action :params="$params['list']" />

    @if ($records->count() > 0)

        <x-table :params="$params['list']" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ $params['list']['noitem'] }}" />
    @endif

</section>
