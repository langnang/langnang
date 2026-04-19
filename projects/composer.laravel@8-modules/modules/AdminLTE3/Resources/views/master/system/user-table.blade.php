@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'User',
        'slug' => 'user',
        'headControls' => ['name', 'slug', 'role', 'query', 'reset', 'export'],
        'bodyColumns' => ['selection', 'name', 'roles', 'email', 'created_at', 'updated_at', 'release_at'],
        'footControls' => ['multiple', 'import', 'create', 'factory', 'export', 'paginator'],
    ])

  </section>
@endsection
