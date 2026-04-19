@props([
    '__name' => 'SimpleMDE',
    '__slug' => 'simplemde',
    '__dscription' => null,
    '__github' => 'sparksuite/simplemde-markdown-editor',
    '__version' => null,
    '__author' => null,
    '__document' => 'https://github.com/sparksuite/simplemde-markdown-editor',
    'name' => null,
    'slug' => null,
    'value' => null,
])

<textarea id="simplemde" name="{{ $name }}">
{!! $value !!}
</textarea>

@push('scripts')
  <!-- summernote -->
  {{-- <script src="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script> --}}
  <x-script slug="simplemde" path="public/plugins/simplemde/1.11.2/simplemde.min.js" src="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js" />
  <script>
    $(function() {
      // Summernote
      var simplemde = new SimpleMDE({
        element: document.querySelector('#simplemde'), // 指定使用的 textarea 元素
        autoDownloadFontAwesome: false, // 是否自动下载 Font Awesome
        autofocus: true, // 是否自动聚焦
        autosave: {
          enabled: true, // 是否启用自动保存
          uniqueId: "SimpleMDE-{{ $slug }}", // 唯一标识符
          delay: 1000, // 自动保存的间隔时间（毫秒）
        },
        blockStyles: {
          bold: "**", // 粗体样式
          italic: "*", // 斜体样式
          code: "```" // 代码块样式
        },
        forceSync: true, // 是否强制同步到原始 textarea
        hideIcons: true, // 是否隐藏图标
        indentWithTabs: true, // 是否使用 Tab 缩进
        lineWrapping: true, // 是否启用自动换行
        renderingConfig: {
          singleLineBreaks: false, // 是否禁用单行换行
          codeSyntaxHighlighting: true // 是否启用代码语法高亮
        },
        showIcons: false, // 是否显示图标
        spellChecker: true // 是否启用拼写检查
      });
    })
  </script>
@endpush

@push('styles')
  <x-style slug="simplemde" path="public/plugins/simplemde/1.11.2/simplemde.min.css" src="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" />
  {{-- <link href="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet"> --}}
@endpush
