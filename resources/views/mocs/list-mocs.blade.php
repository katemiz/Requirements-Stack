<section class="section container">

    <x-title :params="config('mocs.list')" />
    <x-table-action :params="config('mocs.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('mocs.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('mocs.list.noitem') }}" />
    @endif

</section>
