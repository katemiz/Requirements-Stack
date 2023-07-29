<section class="section container">

    <x-title :params="config('roles.list')" />
    <x-table-action :params="config('roles.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('roles.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('roles.list.noitem') }}" />
    @endif

</section>
