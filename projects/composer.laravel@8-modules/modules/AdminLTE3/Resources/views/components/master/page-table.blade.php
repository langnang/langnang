@props([
    'name' => null,
    'slug' => null,
    'title' => null,
    'description' => null,
    'value' => [],
    'showHeader' => true,
    'showHeaderForm' => false,
    'showFooter' => true,
    'paginator',
    'columns' => [],
    '_module' => [],
    'options' => [],
    'actions' => ['query', 'reset', 'export', 'multiple', 'import', 'create', 'factory'],
    'shows' => ['header', 'title', 'description', 'header-form', 'body', 'body-table', 'footer-form', 'footer-paginator'],
])

<div class="card mb-2">
  <div class="card-header d-flex align-items-center py-2">
    @empty($slotHeader)
      <h3 class="card-title mr-auto">
        {{ $title ?? Str::snake($name) . ' Title' }}
        <small class="text-muted"><em>paging {{ $name }} data</em></small>
      </h3>
      @empty($slotHeaderForm)
        <form class="form-inline mb-0" name="table">
          <input type="hidden" name="parent" value="{{ request()->input('parent', 0) }}">
          <div class="form-group ml-1 d-none">
            <select class="form-control form-control-sm" name="module" placeholder="Module" style="width: 120px;">
              <option value="">--Module--</option>
              @foreach (\Module::allEnabled() as $_moduleName => $_moduleObject)
                <option value="{{ $_moduleObject->getAlias() }}" @if (request()->input('module') == $_moduleObject->getAlias()) selected @endif>
                  {{ $_moduleName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group ml-1">
            <input type="text" name="slug" class="form-control form-control-sm" placeholder="--Slug--" value="{{ request()->input('slug') }}" style="width: 120px;">
          </div>
          <div class="form-group ml-1">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="--Name--" value="{{ request()->input('name') }}" style="width: 120px;">
          </div>
          <div class="form-group ml-1">
            <select class="form-control form-control-sm" name="type" style="width: 120px;">
              <option value="">--Type--</option>
              @foreach (Arr::get($module, 'options.meta.type', []) as $option)
                <option value="{{ $option['value'] }}" @if (request()->input('type') == $option['value']) selected @endif>
                  {{ $option['name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group ml-1">
            <select class="form-control form-control-sm" name="status" style="width: 120px;">
              <option value="">--Status--</option>
              @foreach (Arr::get($module, 'options.meta.status', []) as $option)
                <option value="{{ $option['value'] }}" @if (request()->input('status') == $option['value']) selected @endif>
                  {{ $option['name'] }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-sm btn-primary form-control form-control-sm ml-1">
            查询
          </button>
          <a href="metas" class="btn btn-sm btn-secondary form-control form-control-sm ml-1">
            重置
          </a>
          <div class="dropdown">
            <button class="btn btn-info btn-sm dropdown-toggle ml-1" type="button" data-toggle="dropdown" aria-expanded="false">
              下载
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <h6 class="dropdown-header">模板</h6>
              <a class="dropdown-item" href="metas/export?ext=template.csv">CSV</a>
              <a class="dropdown-item" href="metas/export?ext=template.xlsx">Excel</a>
              <a class="dropdown-item" href="metas/export?ext=template.json">JSON</a>
              <a class="dropdown-item" href="metas/export?ext=template.sql">SQL</a>

              <div class="dropdown-divider my-1"></div>
              <h6 class="dropdown-header">查询</h6>
              <button class="dropdown-item">CSV</button>
              <button class="dropdown-item">Excel</button>
              <button class="dropdown-item">JSON</button>
              <button class="dropdown-item">PDF</button>

              <div class="dropdown-divider my-1"></div>
              <h6 class="dropdown-header">已选</h6>
              <button class="dropdown-item">CSV</button>
              <button class="dropdown-item">Excel</button>
              <button class="dropdown-item">JSON</button>
              <button class="dropdown-item">SQL</button>
            </div>
          </div>
        </form>
      @else
        {{ $slotHeaderForm }}
      @endempty
    @else
      {{ $slotheader }}
    @endempty
  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0" style="height: calc(100vh - 275px);">
    <table class="table table-sm table-striped table-hover table-head-fixed text-nowrap">
      <thead>
        <tr>
          <th width="14px">#</th>
          <th>Name</th>
          <th width="70px">Children</th>
          <th width="70px">Relations</th>
          <th width="110px">Type</th>
          <th width="60px">Status</th>
          <th width="50px">Order</th>
          <th width="150px">Created At</th>
          <th width="150px">Updated At</th>
          <th width="150px">Release At</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paginator ?? [] as $item)
          <tr>
            <td>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $item['id'] }}">
              </div>
            </td>
            <td><a class="" href="metas/{{ $item['id'] }}">
                @if (Str::startsWith($item['type'], 'draft-'))
                  <span class="badge badge-secondary">Draft</span>
                @endif
                {{ $item['name'] }}
              </a></td>
            <td>
              @if (in_array($item['type'], ['module', 'category']))
                <a class="" href="metas?parent={{ $item['id'] }}">{{ $item['children_count'] }}</a>
              @else
                -
              @endif
            </td>
            <td>{{ $item['relationships_count'] }}</td>
            <td>{{ $item['type'] }}</td>
            <td>{{ $item['status'] }}</td>
            <td>{{ $item['order'] }}</td>
            <td>{{ $item['created_at'] }}</td>
            <td>{{ $item['updated_at'] }}</td>
            <td>{{ $item['release_at'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  <!-- /.card-body -->
  <div class="card-footer py-2 clearfix d-flex align-items-center">
    @empty($slotFooter)
      <form class="form-inline mb-0 mr-1" action="metas/list" method="get" name="batch-operation">
        <input type="hidden" name="ids" value="">
        <div class="form-check form-check-inline">
          <input class="form-check-input checkbox-toggle mr-0" type="checkbox">
          <button type="button" class="btn btn-sm btn-link form-check-label" style="width: 60px;">全选</button>
        </div>
        <div class="form-group mb-0">
          <select name="operation" class="form-control form-control-sm">
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
      <form class="form-inline mb-0 mr-1" method="post" enctype="multipart/form-data">
        @csrf
        <div class="input-group input-group-sm">
          <div class="custom-file" style="width: 160px;">
            <input type="file" class="custom-file-input" accept=".json,.xls,.xlsx,.csv,.md,.txt,.sql" name="file">
            <label class="custom-file-label justify-content-start text-truncate">Choose file...</label>
          </div>
          <div class="input-group-append">
            <button class="btn btn-info" type="submit">上传</button>
          </div>
        </div>
      </form>
      <div class="mr-auto">
        <a type="button" class="btn btn-sm btn-primary" href="metas/create?{{ Arr::query(request()->query()) }}">新增</a>
        <a type="button" class="btn btn-sm btn-warning" href="metas/factory?{{ Arr::query(request()->query()) }}">Factory</a>
        <button type="button" class="btn btn-sm btn-secondary">打印</button>
        <button type="button" class="btn btn-sm btn-secondary">导出</button>
      </div>
      <span class="mr-1"> 共 {{ $paginator->total() }} 条</span>
      <span class="mr-1"> {{ $paginator->currentPage() }}/{{ $paginator->count() }} </span>
      {{ $paginator->onEachSide(2)->withQueryString(['slug', 'title', 'type', 'status'])->links() }}
    @else
      {{ $slotFooter }}
    @endempty
  </div>
  <!-- /.card-footer -->
</div>
