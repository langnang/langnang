<input type="hidden" name=@isset($list) list[{{ $index }}][id] @else id @endisset value="{{ $item->id }}">

<div class="form-row">
  <div class="form-group col-md-6">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Title</span>
      </div>
      <input type="text" class="form-control @error('title') is-invalid @enderror" name=@isset($list) list[{{ $index }}][title] @else title @endisset value="{{ old(isset($list) ? "list[$index][title]" : 'title', $item['title']) }}">
      @error('title')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Slug</span>
      </div>
      <input type="text" class="form-control" name=@isset($list) list[{{ $index }}][slug] @else slug @endisset value="{{ $item['slug'] ?? '' }}">
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Module</span>
      </div>
      <select class="form-control" name=@isset($list) list[{{ $index }}][module] @else module @endisset>
        <option value="">--Module--</option>
        @foreach ($meta_modules as $meta_module)
          <option value="{{ $meta_module['id'] }}" @if ($meta_module['id'] == old('module', Arr::get($item, 'meta_module.id'))) selected @endif>
            {{ $meta_module['name'] }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group col-md-6">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Ico</span>
      </div>
      <input type="text" class="form-control" name=@isset($list) list[{{ $index }}][ico] @else ico @endisset value="{{ $item['ico'] ?? '' }}">
    </div>
  </div>
  <div class="form-group col-md-3">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Type</span>
      </div>
      <select class="form-control" name=@isset($list) list[{{ $index }}][type] @else type @endisset>
        @foreach (Arr::get($_module, 'options.' . $slug . '.type', []) as $option)
          <option value="{{ $option['value'] }}" @if ($option['value'] == old('type', $item['type'])) selected @endif> {{ $option['name'] }} </option>
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
        @foreach (Arr::get($_module, 'options.' . $slug . '.status', []) as $option)
          <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif> {{ $option['name'] }} </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group col-12">
    <div class="input-group input-group-sm">
      <div class="input-group-prepend">
        <span class="input-group-text">Description</span>
      </div>
      <textarea name=@isset($list) list[{{ $index }}][description] @else description @endisset id="" class="form-control" rows="2">{{ $item['description'] ?? '' }}</textarea>
    </div>
  </div>
  <div class="form-group col-12 mb-0" @if ($full ?? false) style="height: calc(100vh - 454px);overflow-y: auto;" @endif>
    <div class="input-group input-group-sm">
      <textarea name=@isset($list) list[{{ $index }}][text] @else text @endisset id="codeMirror{{ Str::studly($slug) }}{{ isset($index) ? $index : $item->id }}" class="form-control code-mirror" rows="2" style="font-size: 1rem;height: 240px;">{{ $item['text'] ?? '' }}</textarea>
    </div>
  </div>
</div>


@once
  @push('scripts')
    <script src="{{ asset('/public/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('/public/plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('/public/plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('/public/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script src="{{ asset('/public/plugins/codemirror/mode/markdown/markdown.js') }}"></script>
  @endpush
@endonce



@push('scripts')
  <script>
    $(function() {
      if (!$app.codeMirrorEditors) $app.codeMirrorEditors = [];

      $app.codeMirrorEditors["codeMirrorEditor{{ Str::studly($slug) }}{{ isset($index) ? $index : $item->id }}"] = CodeMirror.fromTextArea(document.getElementById("codeMirror{{ Str::studly($slug) }}{{ isset($index) ? $index : $item->id }}"), {
        mode: "markdown",
        lineNumbers: true, // 显示行数 
        indentUnit: 4, // 缩进单位为4 
        styleActiveLine: true, // 当前行背景高亮 
        matchBrackets: true, // 括号匹配 
        lineWrapping: true, // 自动换行 
        theme: 'monokai', // 使用monokai模板
      });


    })
  </script>
@endpush
@once
  @push('styles')
    <link rel="stylesheet" href="{{ asset('/public/plugins/dropzone/5.9.3/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/plugins/codemirror/theme/monokai.css') }}">
    <style>
      .note-editor.card {
        margin-bottom: 0;
      }

      .codeMirror {
        height: auto !important;
        width: 100%;
        font-size: .875rem;
        font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, monospace;
      }

      .codeMirror-scroll {
        height: auto !important;
        min-height: 100px;
      }
    </style>
  @endpush
@endonce

@if ($full ?? false)
  @once
    @push('styles')
      <style>
        .CodeMirror-wrap {
          width: 100% !important;
          /* height: calc(100vh - 459px); */
          /* overflow-y: auto; */
        }

        .CodeMirror-code {
          min-height: calc(100vh - 462px);
          /* overflow-y: auto; */
        }
      </style>
    @endpush
  @endonce
@endif
