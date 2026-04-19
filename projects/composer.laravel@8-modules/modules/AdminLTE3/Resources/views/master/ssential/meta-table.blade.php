@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'Meta',
        'slug' => 'meta',
        'headControls' => ['parent', 'name', 'slug', 'type', 'status', 'query', 'reset', 'export'],
        'bodyColumns' => ['selection', 'name', 'children_count', 'relationships_count', 'type', 'status', 'order', 'created_at', 'updated_at', 'release_at'],
        'footControls' => ['multiple', 'import.json.xlsx.csv', 'create', 'factory', 'export', 'paginator'],
    ])

  </section>
@endsection
