<section class="section container">

    <x-title :params="config('users.list')" />
    <x-table-action :params="config('users.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('users.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('users.list.noitem') }}" />
    @endif

</section>
