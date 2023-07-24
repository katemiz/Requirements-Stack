<section class="section container">

    <x-title :params="config('dgates.list')" />
    <x-table-action :params="config('dgates.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('dgates.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('dgates.list.noitem') }}" />
    @endif

</section>
