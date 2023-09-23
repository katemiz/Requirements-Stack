<section class="section container">

    <x-title :params="config('companies.list')" />
    <x-table-action :params="config('companies')" />

    @if ($records->count() > 0)

        <x-table :params="config('companies')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('companies.list.noitem') }}" />
    @endif

</section>
