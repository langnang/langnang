@props([
    '__name' => 'CodeMirror',
    '__slug' => 'codemirror',
    '__dscription' => null,
    '__github' => 'codemirror/basic-setup',
    '__version' => null,
    '__author' => null,
    '__homepage' => '',
    '__document' => 'https://codemirror.net/',
    'name' => null,
    'slug' => null,
    'value' => null,
])

<textarea id="codeMirror{{ Str::studly($slug) }}" class="p-3"></textarea>

@once
  @push('scripts')
    <!-- CodeMirror -->
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/codemirror.js"></script>
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/mode/css/css.js"></script>
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/mode/xml/xml.js"></script>
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/mode/javascript/javascript.js"></script>
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/mode/markdown/markdown.js"></script>
    <script src="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
  @endpush
@endonce
@push('scripts')
  <script>
    $(function() {
      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirror{{ Str::studly($slug) }}"), {
        //   mode: "javascript",
        //   theme: "monokai",
        //Js高亮显示
        // mode: "application/json",
        mode: "markdown",
        indentUnit: 2, // 缩进单位，默认2
        smartIndent: true, // 是否智能缩进
        //显示行号
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true, // 自动换行 
        //设置主题
        theme: "monokai",
        //代码折叠
        lineWrapping: true,
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter", "CodeMirror-lint-markers"],
        //CodeMirror-lint-markers是实现语法报错功能
        lint: true,

        //全屏模式
        fullScreen: true,
      });
    })
  </script>
@endpush
@once
  @push('styles')
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/codemirror.css">
    <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master') }}/plugins/codemirror/theme/monokai.css">
  @endpush
@endonce
@push('styles')
@endpush
