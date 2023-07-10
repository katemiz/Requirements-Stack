<div class="field">
    <label class="label">{{ $params['label'] }}</label>
    <div class="control">
      <div class="select">
        <select>
          <option>Select</option>

          @foreach ($params['options'] as $key => $value)

          <option value="{{ $key }}" @selected( count($params['options']))>{{ $value }}</option>

              
          @endforeach
        </select>
      </div>
    </div>
</div>