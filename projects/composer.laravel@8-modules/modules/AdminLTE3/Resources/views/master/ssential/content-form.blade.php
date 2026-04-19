@extends('admin::layouts.master')


@if (isset($item))
  @section('content')
    <section class="content">
      @include('admin::master.shared.page.data-item', [
          'name' => 'Content',
          'slug' => 'content',
          'headControls' => ['spider', 'submit'],
          'bodyColumns' => ['selection', 'title', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
          'itemControls' => [],
          'footControls' => ['import', 'create', 'factory', 'submit'],
      ])
    </section>
  @endsection


  @push('scripts')
    <script>
      // $(document).Toasts('create', {
      //   title: 'Toast Title',
      //   autohide: true,
      //   delay: 750,
      //   body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      // })
      $(function() {
        $(document).on('click', '[name="foot-submit"]', function($e) {
          console.log($e);
          $('[name="text"]').val($app.codeMirrorEditors["codeMirrorEditorContent"].getValue());
          console.log($('[name="text"]').val());
          $('form#data-item').submit();
        });
      })
    </script>
  @endpush
@elseif(isset($list))
  @section('content')
    <section class="content">
      @include('admin::master.shared.page.data-list', [
          'name' => 'Content',
          'slug' => 'content',
          'headControls' => ['parent', 'module', 'type', 'status', 'reset', 'export', 'submit'],
          'bodyColumns' => ['selection', 'title', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
          'listControls' => ['spider'],
          'footControls' => ['multiple', 'import', 'create', 'factory', 'export', 'submit'],
      ])
    </section>
  @endsection
@endif
