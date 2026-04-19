<input type="hidden" name=@isset($list) list[{{ $index }}][id] @else id @endisset value="{{ $item->id }}">

<div class="form-row">
  <div class="form-group col-md-6">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Title</span>
      </div>
      <input type="text" class="form-control" name=@isset($list) list[{{ $index }}][title] @else title @endisset placeholder="--Title--" value="{{ old('title', $item['title']) }}"required>
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Slug</span>
      </div>
      <input type="text" class="form-control" name=@isset($list) list[{{ $index }}][slug] @else slug @endisset placeholder="--Slug--" value="{{ $item['slug'] ?? '' }}">
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Module</span>
      </div>
      <select class="form-control" name=@isset($list) list[{{ $index }}][module] @else module @endisset>
        <option value="">--Module--</option>
        @foreach (Module::all() ?? [] as $moduleName => $moduleObject)
          <option value="{{ $moduleObject->getAlias() }}" @if ($moduleObject->getAlias() == old('module', $item['module'])) selected @endif>
            {{ $moduleName }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group col-md-4">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Ico</span>
      </div>
      <input type="text" class="form-control" name=@isset($list) list[{{ $index }}][ico] @else ico @endisset placeholder="--Ico--" value="{{ $item['ico'] ?? '' }}">
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Type</span>
      </div>
      <select class="form-control" name=@isset($list) list[{{ $index }}][type] @else type @endisset>
        <option value="">--Type--</option>
        @foreach (Arr::get($_module, 'options.' . $slug . '.type', []) as $option)
          <option value="{{ $option['value'] }}" @if ($option['value'] == old('type', $item['type'])) selected @endif>
            {{ $option['name'] }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Status</span>
      </div>
      <select class="form-control" name=@isset($list) list[{{ $index }}][status] @else status @endisset>
        <option value="">--Status--</option>
        @foreach (Arr::get($_module, 'options.' . $slug . '.status', []) as $option)
          <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif>
            {{ $option['name'] }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group col-md-2">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Order</span>
      </div>
      <input type="number" min="0" max="99" class="form-control" name=@isset($list) list[{{ $index }}][order] @else order @endisset placeholder="--Order--" value="{{ $item['order'] ?? 0 }}">
    </div>
  </div>
  <div class="form-group col-md-12">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Description</span>
      </div>
      <textarea name=@isset($list) list[{{ $index }}][description] @else description @endisset class="form-control" rows="1">{{ $item['description'] ?? '' }}</textarea>
    </div>
  </div>
</div>
