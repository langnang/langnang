<div method="post" name="data-list" class="card mb-2">
  <div class="card-header d-flex align-items-center py-2">
    <h3 class="card-title mr-auto">
      {{ Str::plural($name) }} DataList
      <small class="text-muted d-none"><em>paging {{ Str::plural($slug) }} paginator data</em></small>
    </h3>
    @include('admin::master.shared.datatable-head-form')
  </div>
  <!-- /.card-header -->
  <form id="data-list" name="data-list" method="post" action="" class="list-group list-group-flush" style="height: calc(100vh - 275px);overflow-y: auto;">
    @csrf
    @foreach ($headControls ?? [] as $control)
      @if (in_array($control, ['parent', 'module', 'type', 'status', 'spider']))
        <input type="hidden" name="{{ $control }}" value="{{ request()->input($control) }}">
      @endif
    @endforeach
    @foreach ($list ?? [] as $index => $item)
      <li class="list-group-item pl-1 pr-2 pt-2 pb-0" style="border-left: .25rem solid  @error("$index.*"){{ '' }}#bd2130{{ '' }}@else{{ '' }}transparent{{ '' }}@enderror;">
        <div class="d-flex align-items-center w-100 pb-2">
          <div class="form-check">
            <input class="form-check-input" name="list[{{ $index }}][id]" type="checkbox" value="{{ $item->id ?? $index + 1 }}" style="margin-top: -6px;" />
          </div>
          <a class="h2 mb-0 flex-fill" data-toggle="collapse" href="#{{ $slug }}-{{ $index + 1 }}">
            <small class="text-muted"> #{{ $item->id ?? $index + 1 }}</small>
          </a>
          @foreach ($listControls ?? [] as $control)
            @switch($control)
              @case('spider')
                <div class="form-group mb-0 ml-1">
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name='list[{{ $index }}][{{ $control }}]' placeholder="--{{ Str::studly($control) }}--" value="{{ request()->input($control) }}" style="width: 120px;" />
                    <div class="input-group-append">
                      <span class="input-group-text bg-warning text-dark"><i class="fas fa-spider"></i></span>
                    </div>
                  </div>
                </div>
              @break
            @endswitch
          @endforeach
          @if ($errors->any())
            @error("$index.*")
              <h4 class="m-0 text-danger"><i class="icon fas fa-ban"></i></h5>
              @else
                <h4 class="m-0 text-success"><i class="icon fas fa-check"></i></h5>
                @enderror
          @endif
        </div>
        <div class="collapse show" id="{{ $slug }}-{{ $index + 1 }}">
          @include('admin::master.shared.form.' . $slug, ['slug' => $slug])
        </div>
      </li>
    @endforeach
  </form>
  <!-- /.card-body -->
  <div class="card-footer py-2 clearfix d-flex align-items-center">
    @include('admin::master.shared.datatable-foot-form')
  </div>
  <!-- /.card-footer -->
</div>

@once
  @push('scripts')
    <script>
      $(function() {
        $(document).on('click', '#head-submit, #foot-submit', function($e) {
          console.log($e);
          const headFormData = new FormData(document.getElementById('head-form'));
          const headJsonData = {};

          headFormData.forEach((value, key) => {
            if (!headJsonData[key]) {
              headJsonData[key] = headFormData.getAll(key).length > 1 ? headFormData.getAll(key) : headFormData.get(key);
              $(`form#data-list [name=${key}]`).val(headJsonData[key]);
            }
          });
          // console.log(`headFormData`, headFormData, headJsonData)
          $('form#data-list').submit();
        });
      })
    </script>
  @endpush
@endonce
