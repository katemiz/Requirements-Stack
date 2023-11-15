<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Companies</h1>
    <h2 class="subtitle has-text-weight-light">{{ $cid ? $constants['update'] : $constants['create'] }}</h2>
</header>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">

        <label class="label">Company Name (Short)</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter company short name ..." required>
        </div>

        @error('name')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="field">

        <label class="label">Company Fullname</label>
        <div class="control">

            <input
                class="input"
                wire:model="fullname"
                type="text"
                placeholder="Enter company fullname ..." required>
        </div>

        @error('fullname')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
            @if ($cid)
                {{ $constants['update']['submitText'] }}
            @else
                {{ $constants['create']['submitText'] }}
            @endif
        </button>
    </div>

</form>

