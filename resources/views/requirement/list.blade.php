<section class="section container">

    <x-title :params="config('requirements.list')" />
    <x-table-action :params="config('requirements.list')" />

    @if ($records->count() > 0)

        <x-table :params="config('requirements.list')" :records="$records" />
        {{ $records->links('pagination.bulma') }}

    @else
        <x-notification type="is-warning is-light" message="{{ config('requirements.list.noitem') }}" />
    @endif

</section>