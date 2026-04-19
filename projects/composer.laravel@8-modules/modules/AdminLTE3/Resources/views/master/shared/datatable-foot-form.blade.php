<div name="foot-left" class="d-flex">
  @foreach ($footControls ?? [] as $control)
    @php
      $control = explode('.', $control);
      $modifiers = array_splice($control, 1);
      $control = $control[0];
    @endphp
    @switch($control)
      @case('multiple')
        <form id="foot-{{ $control }}" name="form-{{ $control }}" class="form-inline ml-0 mb-0 mr-1" action="{{ Str::plural($slug) }}/list" method="get" name="batch-operation">
          <input id="foot-ids" name="ids" type="hidden" value="">
          <div class="form-check form-check-inline mr-0">
            <input id="foot-check-all" class="form-check-input checkbox-toggle mr-0" type="checkbox">
            <button id="btn-check-all" type="button" class="btn btn-sm btn-link form-check-label" data-target="[name='check-item']" style="width: 65px;">全选</button>
          </div>
          <div class="form-group mb-0">
            <select id="foot-operation" name="operation" class="form-control form-control-sm">
              <option>--Operation--</option>
              <optgroup label="选中项：">
                <option value="update">编辑</option>
                <option value="copy">复制</option>
                <option value="delete">删除</option>
                <option value="remove">移动</option>
              </optgroup>
              <optgroup label="导出：">
                <option value="export-json">JSON</option>
                <option value="export-csv">CSV</option>
                <option value="export-xlsx">Excel</option>
                <option value="export-pdf">PDF</option>
              </optgroup>
            </select>
          </div>
        </form>
      @break

      @case('import')
        <form id="foot-{{ $control }}" name="form-{{ $control }}" class="form-inline mb-0 mr-1" method="post" enctype="multipart/form-data">
          @csrf
          <div class="input-group input-group-sm">
            <div class="custom-file" style="width: 100px;">
              <input id="foot-{{ $control }}-file" name="file" type="file" class="custom-file-input" accept=@empty($modifiers).json,.xls,.xlsx,.csv,.md,.sql,.txt, @else .{{ implode(',.', $modifiers) }}, @endempty name="file">
              <label class="custom-file-label justify-content-start text-truncate" for="foot-{{ $control }}-file">Choose file...</label>
            </div>
            <div class="input-group-append">
              <button name="foot-{{ $control }}" class="btn btn-info" type="submit">
                <i class="fas fa-upload"></i>
                Import
              </button>
            </div>
          </div>
        </form>
      @break

      @case('create')
        <form id="foot-{{ $control }}" name="form-{{ $control }}" class="form-inline mb-0" action="{{ url('admin/ssential/' . Str::plural($slug)) }}/{{ $control }}?{{ request()->getQueryString() }}">
          <input type="hidden" name="parent" value="{{ request('parent') }}">
          <div class="form-group ml-1">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control pl-1 pr-0" name='num' value="{{ request()->input('num', 1) }}" style="width: 28px;">
              <div class="input-group-append">
                <button class="btn btn-sm btn-primary mr-1" type="submit">
                  <i class="fas fa-plus"></i>
                  {{ Str::studly($control) }}
                </button>
              </div>
            </div>
          </div>
        </form>
      @break

      @case('factory')
        <form id="foot-{{ $control }}" name="form-{{ $control }}" class="form-inline mb-0" action="{{ url('admin/ssential/' . Str::plural($slug)) }}/{{ $control }}?{{ request()->getQueryString() }}">
          <input type="hidden" name="parent" value="{{ request('parent') }}">
          <div class="form-group ml-1">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control pl-1 pr-0" name='num' value="{{ request()->input('num', 1) }}" style="width: 28px;">
              <div class="input-group-append">
                <button class="btn btn-sm btn-warning mr-1" type="submit">
                  <i class="fas fa-industry"></i>
                  {{ Str::studly($control) }}
                </button>
              </div>
            </div>
          </div>
        </form>
      @break

      @case('print')
        <button id="foot-{{ $control }}" type="button" class="btn btn-sm btn-secondary mr-1">
          <i class="fas fa-print"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @case('export')
        <button id="foot-{{ $control }}" type="button" class="btn btn-sm btn-secondary mr-1">
          <i class="fas fa-download"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @default
    @endswitch
  @endforeach
</div>
<div name="foot-center" class="d-flex">

</div>
<div name="foot-right" class="d-flex ml-auto">
  @foreach ($footControls ?? [] as $control)
    @php
      $control = explode('.', $control);
      $modifiers = array_splice($control, 1);
      $control = $control[0];
    @endphp
    @switch($control)
      @case('submit')
        <button id="foot-{{ $control }}" type="button" class="btn btn-sm btn-primary ml-1">
          <i class="fas fa-check"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @case('confirm')
        <button id="foot-{{ $control }}" type="button" class="btn btn-sm btn-warning ml-1">
          <i class="fas fa-check-double"></i>
          {{ Str::studly($control) }}
        </button>
      @break

      @case('paginator')
        <div class="ml-auto" style="display: ruby">
          <span class="mr-1"> 共 {{ $paginator->total() }} 条</span>
          <span class="mr-1"> {{ $paginator->currentPage() }}/{{ $paginator->count() }} </span>
          {{ $paginator->withQueryString()->onEachSide(3)->links() }}
        </div>
      @break

      @default
    @endswitch
  @endforeach
</div>



@once
  @push('scripts')
    <script src="{{ asset('/public/plugins/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js') }}"></script>
    <script>
      $(function() {

      })
    </script>
    <script>
      $(function() {
        bsCustomFileInput.init();
      })
    </script>
  @endpush
  @push('styles')
    <style>
      form#foot-import .custom-file-input:lang(en)~.custom-file-label::after {
        display: none;
      }
    </style>
  @endpush
@endonce
