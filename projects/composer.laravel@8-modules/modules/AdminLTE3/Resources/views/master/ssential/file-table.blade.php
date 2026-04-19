@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'File',
        'slug' => 'file',
        'headControls' => ['parent', 'module', 'name', 'slug', 'type', 'status', 'query', 'reset', 'export.template'],
        'bodyColumns' => ['selection', 'name', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
        'footControls' => ['multiple', 'import', 'export', 'paginator'],
    ])
  </section>
@endsection
