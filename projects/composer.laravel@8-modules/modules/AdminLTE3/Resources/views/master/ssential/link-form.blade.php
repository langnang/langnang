@extends('admin::layouts.master')


@if (isset($item))
  @section('content')
    <section class="content">
      @include('admin::master.shared.page.data-item', [
          'name' => 'Link',
          'slug' => 'link',
          'headControls' => ['spider', 'submit'],
          'bodyColumns' => ['selection', 'title', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
          'footControls' => ['create', 'factory', 'submit'],
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
        $(document).on('click', '[name="head-submit"],[name="foot-submit"]', function($e) {
          $('form#data-item').submit();
        });
      })
    </script>
  @endpush
@elseif(isset($list))
  @section('content')
    <section class="content">
      @include('admin::master.shared.page.data-list', [
          'name' => 'Link',
          'slug' => 'link',
          'headControls' => ['parent', 'module', 'type', 'status', 'reset', 'export', 'submit'],
          'bodyColumns' => ['selection', 'title', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
          'footControls' => ['multiple', 'create', 'factory', 'export', 'submit'],
      ])
    </section>
  @endsection

  @push('scripts')
    <script>
      $(function() {
        $(document).on('click', '[name="head-submit"],[name="foot-submit"]', function($e) {
          console.log($e);
          $('form#data-list').submit();
        });
      })
    </script>
  @endpush

@endif
