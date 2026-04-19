@php
  // $_layout = $_layout ?? [];
  // $_layout['header'] = $branches ?? $categories;
  // $_layout['aside'] = $tree['children'];
@endphp
@extends($prefix . '.layout')

@section('content')
  @foreach ($tree['children'] ?? [] as $category)
    @if (count($category['contents']) > 0)
      <div class="card card-sm mb-3" id="{{ $category['name'] }}">
        <div class="card-header">
          <i class="bi bi-tag" style="margin-right: 7px;"></i>
          {{ $category['name'] }}
        </div>
        <div class="card-body pb-0">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            @foreach ($category['contents'] as $site)
              <div class="col mb-2 pl-1 pr-1">
                @include('webstack._shared.site-card', ['data' => $site])
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif
    @if (count($category['children']) > 0)
      @foreach ($category['children'] as $subCategory)
        <div class="card card-sm mb-3" id="{{ $subCategory['name'] }}">
          <div class="card-header">
            <i class="bi bi-tag" style="margin-right: 7px;"></i>
            {{ $subCategory['name'] }}
          </div>
          <div class="card-body pb-0">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
              @foreach ($subCategory['contents'] as $site)
                <div class="col mb-2 pl-1 pr-1">
                  @include('webstack._shared.site-card', ['data' => $site])
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endforeach
    @endif
  @endforeach
@endsection
