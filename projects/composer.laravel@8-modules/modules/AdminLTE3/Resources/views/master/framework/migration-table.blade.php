@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'Migration',
        'slug' => 'migration',
        'headControls' => ['migration', 'query', 'reset'],
        'bodyColumns' => ['migration', 'batch'],
        'footControls' => ['import', 'create', 'factory', 'export', 'paginator'],
    ])

  </section>
@endsection
