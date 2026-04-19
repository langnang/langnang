<form id="head-form" class="form-inline mb-0" name="table">
  @foreach ($headControls ?? [] as $control)
    @php
      $control = explode('.', $control);
      $modifiers = array_splice($control, 1);
      $control = $control[0];
    @endphp
    @switch($control)
      @case('parent')
        <input type="hidden" name="parent" value="{{ request()->input('parent', 0) }}">
      @break

      @case('key')
      @case('name')

      @case('title')
      @case('slug')

      @case('migration')
        <div class="form-group ml-1">
          <input type="text" class="form-control form-control-sm" name="{{ $control }}" placeholder="--{{ Str::studly($control) }}--" value="{{ request()->input($control) }}" style="width: 100px;">
        </div>
      @break

      @case('spider')
        <div class="form-group ml-1">
          <div class="input-group input-group-sm">
            <input type="text" class="form-control" name='{{ $control }}' placeholder="--{{ Str::studly($control) }}--" value="{{ request()->input($control) }}">
            <div class="input-group-append">
              <button class="btn btn-info" type="submit"><i class="fas fa-spider"></i></button>
            </div>
          </div>
        </div>
      @break

      @case('module')
        <div class="form-group ml-1">
          <select class="form-control form-control-sm" name="module" placeholder="Module" style="width: 100px;">
            <option value="">--Module--</option>
            @foreach ($meta_modules as $meta_module)
              <option value="{{ $meta_module['id'] }}" @if ($meta_module['id'] == old('module')) selected @endif>
                {{ $meta_module['name'] }}
              </option>
            @endforeach
          </select>
        </div>
      @break

      @case('type')
      @case('status')

      @case('role')
        <div class="form-group ml-1">
          <select class="form-control form-control-sm" name="{{ $control }}" style="width: 100px;">
            <option value="">--{{ Str::studly($control) }}--</option>
            @foreach (Arr::get($_options ?? [], $slug . '.' . $control, []) as $option)
              <option value="{{ $option['value'] }}" @if (request()->input($control) == $option['value']) selected @endif>
                {{ $option['name'] }}</option>
            @endforeach
          </select>
        </div>
      @break

      @case('query')
        <button type="submit" class="btn btn-sm btn-primary form-control form-control-sm ml-1">
          <i class="fas fa-search"></i>
          查询
        </button>
      @break

      @case('submit')
        <button type="submit" name="head-{{ $control }}" class="btn btn-sm btn-primary form-control form-control-sm ml-1">
          <i class="fas fa-check"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @case('confirm')
        <button id="foot-{{ $control }}" type="button" class="btn btn-sm btn-warning form-control form-control-sm ml-1">
          <i class="fas fa-check-double"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @case('reset')
        <a href="{{ url(request()->path()) }}" class="btn btn-sm btn-secondary form-control form-control-sm ml-1">
          <i class="fas fa-redo"></i>
          重置
        </a>
      @break

      @case('export')
        <div class="dropdown">
          <button class="btn btn-info btn-sm dropdown-toggle ml-1" type="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-download"></i>
            下载
          </button>

          <div class="dropdown-menu dropdown-menu-right">
            @if (empty($modifiers) || in_array('template', $modifiers))
              <h6 class="dropdown-header">模板</h6>
              <a class="dropdown-item" href="{{ url(request()->path()) }}/export?ext=template.json">JSON</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=template.xlsx">Excel</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=template.csv">CSV</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=template.sql">SQL</a>
            @endif
            @if (empty($modifiers) || in_array('selection', $modifiers))
              <div class="dropdown-divider my-1"></div>
              <h6 class="dropdown-header">已选</h6>
              <a class="dropdown-item" href="{{ url(request()->path()) }}/export?ext=selection.json">JSON</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=selection.xlsx">Excel</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=selection.csv">CSV</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=selection.sql">SQL</a>
            @endif
            @if (empty($modifiers) || in_array('query', $modifiers))
              <div class="dropdown-divider my-1"></div>
              <h6 class="dropdown-header">查询</h6>
              <a class="dropdown-item" href="{{ url(request()->path()) }}/export?ext=query.json">JSON</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=query.xlsx">Excel</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=query.csv">CSV</a>
              <a class="dropdown-item disabled" href="{{ url(request()->path()) }}/export?ext=query.sql">PDF</a>
            @endif
          </div>
        </div>
      @break

      @default
    @endswitch
  @endforeach
</form>
