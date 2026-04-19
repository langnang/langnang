@extends('admin::layouts.master')

@section('content')
  <section class="content">
    @include('admin::master.shared.page.data-table', [
        'name' => 'Option',
        'slug' => 'option',
        'headControls' => ['key', 'query', 'reset'],
        'bodyColumns' => ['key', 'expiration'],
        'footControls' => ['multiple', 'import', 'create', 'factory', 'export', 'paginator'],
    ])

  </section>
@endsection
