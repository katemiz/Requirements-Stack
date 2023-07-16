<section class="section container">

    <x-title :params="config('projects.list')" />
    <x-table-action :params="config('projects.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('projects.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('projects.list.noitem') }}" />
    @endif

</section>
