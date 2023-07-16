<div class="field">
    <label class="label">{{ $params['label'] }}</label>
    <div class="control">
      <div class="select">
        <select name="{{ $params['name'] }}">
          <option>Select</option>

          @foreach ($params['options'] as $key => $v)
            <option value="{{ $key }}" @selected( count($params['options']) == 1 || $key == $value)>{{ $v }}</option>
          @endforeach

        </select>
      </div>
    </div>

    @error($params['name'])
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror
</div>