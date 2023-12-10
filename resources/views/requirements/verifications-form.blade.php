<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $vid ? $constants['update']['subtitle'] : $constants['create']['subtitle'] }}</h2>
    </header>

    <div class="card has-background-info-light">

        <div class="card-content">
            <div class="media">
            <div class="media-content">
                <p class="title is-4">
                <span>{{ $requirement->rtype }}-{{ $requirement->requirement_no }} R{{ $requirement->revision }}</span>
                </p>
                <p class="subtitle is-6">@ {{ $requirement->created_at }}</p>
            </div>

            <div class="media-content">
                <h4 class="subtitle has-text-weight-normal my-0">Project</h4>
                <span class="tag is-black">{{ $requirement->getProjectNameAttribute() }}</span>
            </div>

            <div class="media-content">
                <h4 class="subtitle has-text-weight-normal my-0">End Product</h4>
                @if ($endproduct_id > 0)
                <span class="tag is-info">{{ $requirement->getEndProductNameAttribute()}}</span>
                @endif
            </div>

            </div>

            <div class="content">
            <p>{!! $requirement->text !!}</p>


            @if ( !empty($remarks) )
            <h4 class="subtitle has-text-weight-normal mt-3">Remarks</h4>

            <p>{!! $remarks !!}</p>
            <h4 class="subtitle has-text-weight-normal mt-3">Verifications</h4>
            @endif

            </div>
        </div>


    </div>

    <div class="column card mt-3">


    <form method="POST" enctype="multipart/form-data">
    @csrf



    <div class="field is-half">
        <div class="field-body">

            <div class="field">
                <label class="label">Milestone/Decision Gate</label>
                <div class="control">
                    <div class="select">
                    <select wire:model='gate_id'>
                        <option>Select a milestone/gate...</option>
                            @foreach ($verification_data['ver_milestones'] as $milestone)
                                <option value="{{ $milestone->id }}">{{ $milestone->code }} {{ $milestone->name }}</option>
                            @endforeach
                    </select>
                    </div>
                </div>

                @error('gate_id')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="field is-half">
                <label class="label">MOC</label>
                <div class="control">
                    <div class="select">
                    <select wire:model='moc_id'>
                        <option>Select a means of compliance...</option>
                            @foreach ($verification_data['ver_mocs'] as $moc)
                                <option value="{{ $moc->id }}">{{ $moc->code }} {{ $moc->name }}</option>
                            @endforeach
                    </select>
                    </div>
                </div>

                @error('moc_id')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>





    <div class="field ">
        <div class="field-body">

            <div class="field is-half">
                <label class="label">POC</label>
                <div class="control">
                    <div class="select">
                    <select wire:model='poc_id'>
                        <option>Select a proof of compliance...</option>
                            @foreach ($verification_data['ver_pocs'] as $poc)
                                <option value="{{ $poc->id }}">{{ $poc->code }} {{ $poc->name }}</option>
                            @endforeach
                    </select>
                    </div>
                </div>

                @error('poc_id')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="field is-half">
                <label class="label">Witness</label>
                <div class="control">
                    <div class="select">
                    <select wire:model='witness_id'>
                        <option>Select a witness ...</option>
                            @foreach ($verification_data['ver_witnesses'] as $witness)
                                <option value="{{ $witness->id }}">{{ $witness->code }}</option>
                            @endforeach
                    </select>
                    </div>
                </div>

                @error('witness_id')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>




















    {{-- <div class="column"> --}}
        {{-- <input type="hidden" name="reqid" value="{{ $uid }}" />
        <input type="hidden" name="projectid" value="{{ $the_project->id }}" /> --}}
        {{-- <x-select :params="config('verifications.form.dgate')" value=" {{ $vid ? $vid->meeting_id : ''}}"/>
        <x-select :params="config('verifications.form.moc')" value=" {{ $vid ? $verification->moc_id : ''}}"/>
        <x-select :params="config('verifications.form.poc')" value=" {{ $vid ? $verification->poc_id : ''}}"/>
        <x-select :params="config('verifications.form.witness')" value=" {{ $vid ? $verification->witness_id : ''}}"/> --}}
    {{-- </div> --}}


    {{-- <x-form-editor :params="config('verifications.form.remarks')" value="{{ $verification ? $verification->remarks : '' }}"/> --}}

    <livewire:ck-editor
        wire:model="vremarks"
        label='Verification Notes/Remarks'
        placeholder='Add any note on verification ....'
        :content="$vremarks"/>

    @error('vremarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror





    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
            @if ($vid)
                Update Verification
            @else
                Add Verification
            @endif
        </button>
    </div>




    </form>
    </div>


</section>
