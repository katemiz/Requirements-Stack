
<x-layout>

<section class="section container">

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>


    <x-title :params="config('verifications')[$action]" />

    <div class="card has-background-info-light">

        <div class="card-content">
          <div class="media">
            <div class="media-content">
              <p class="title is-4">
                <span>{{ $requirement->rtype }}-{{ $requirement->id }}</span>
              </p>
              <p class="subtitle is-6">@ {{ $requirement->created_at }}</p>
            </div>

            <div class="media-content">

              <h4 class="subtitle has-text-weight-normal my-0">Project</h4>
              <span class="tag is-black">{{ $requirement->project->code }}</span>
            </div>

            <div class="media-content">

              <h4 class="subtitle has-text-weight-normal my-0">End Products</h4>
              @foreach ($requirement->endproducts as $ep)
              <span class="tag is-info">{{ $ep->code}}</span>
              @endforeach
            </div>


          </div>

          <div class="content">
            <p>{!! $requirement['text'] !!}</p>

            <h4 class="subtitle has-text-weight-normal mt-3">Remarks</h4>

            @if ( !empty($requirement['remarks']) )
            <p>{!! $requirement['remarks'] !!}</p>
            <h4 class="subtitle has-text-weight-normal mt-3">Verifications</h4>
            @endif




            @if ($requirement->updated_at != $requirement->created_at)
            <div class="is-size-7 has-text-grey-light">
                Updated @ {{ $requirement->updated_at }}
            </div>
            @endif

          </div>
        </div>


    </div>

    <div class="column card mt-3">

    <form action="{{ config('verifications.cu_route') }}{{ $requirement ? $requirement->id : '' }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="columns">

        <div class="column">
            <x-select :params="config('verifications.form.dgate')" value=" {{ $verification ? $verification->meeting_id : ''}}"/>

        </div>

        <div class="column">
            <x-select :params="config('verifications.form.moc')" value=" {{ $verification ? $verification->moc_id : ''}}"/>

        </div>

        <div class="column">
            <x-select :params="config('verifications.form.poc')" value=" {{ $verification ? $verification->poc_id : ''}}"/>

        </div>

        <div class="column">
            <x-select :params="config('verifications.form.witness')" value=" {{ $verification ? $verification->witness_id : ''}}"/>

        </div>

    </div>


    <x-form-editor :params="config('verifications.form.remarks')" value="{{ $requirement ? $requirement->remarks : '' }}"/>

    <div class="buttons is-right">
        <button class="button is-dark">{{ config('verifications')[$action]['submitText'] }}</button>
    </div>

    </form>
    </div>


</section>
</x-layout>

