@props([
    '__name' => 'SummerNote',
    '__slug' => 'summernote',
    '__dscription' => null,
    '__github' => 'summernote/summernote',
    '__version' => null,
    '__author' => null,
    '__document' => 'https://github.com/summernote/summernote/',
    'name' => null,
    'slug' => null,
    'value' => null,
])

<textarea id="summernote">
{!! $value !!}
</textarea>

@push('scripts')
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('/modules/Admin/Public/master') }}/plugins/summernote/summernote-bs4.min.css">
  <script>
    $(function() {
      // Summernote
      $('#summernote').summernote()
    })
  </script>
@endpush

@push('styles')
@endpush
