<div class="field">
    <label class="label">{{ $params['label'] }}</label>

    <div class="control">

        @if ( count($params['options']) > 0)
            
            @foreach ($params['options'] as $key => $v)

                <label class="checkbox">
                    <input type="checkbox" name="{{$params['name']}}{{$key}}"> {{ $v }}
                </label>

            @endforeach

        @else  
            <p>{{ $params['nooptions'] }}</p>
        @endif

    </div>
</div>