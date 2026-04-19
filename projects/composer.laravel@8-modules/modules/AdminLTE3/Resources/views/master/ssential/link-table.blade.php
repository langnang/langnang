@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'Link',
        'slug' => 'link',
        'headControls' => ['parent', 'module', 'title', 'slug', 'type', 'status', 'query', 'reset', 'export'],
        'bodyColumns' => ['selection', 'title', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
        'footControls' => ['multiple', 'import', 'create', 'factory', 'export', 'paginator'],
    ])
  </section>
@endsection
