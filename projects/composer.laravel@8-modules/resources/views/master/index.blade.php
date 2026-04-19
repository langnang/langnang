@extends('layouts.master')

@section('content')
  <div class="container">
    <main class="row">
      <div class="col-12 col-lg-9">
        @isset($meta)
          <div class="alert alert-warning alert-dismissible fade show my-2" role="alert">
            <strong>{{ Arr::get($_module, 'options.meta.type.' . $meta->type . '.nameCn', $meta->type) }}:</strong>
            {{ $meta->name }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endisset

        @empty($posts)
        @else
          @section('posts')
            <section data-role="content_post-page" lazy-url="{{ url('section') }}?view={{ $alias }}({{ Arr::get($_module, 'meta.id') }})::master:content_page&{{ Arr::query(request()->all()) }}">
              {{-- @include('master.sections.content_post-page') --}}
              <div class="card my-2  border-secondary  border-primary ">
                <div class="card-header d-flex align-items-center">
                  <i class="bi bi-circle-fill mr-2  text-secondary  text-primary " data-toggle="tooltip" data-placement="right" title="public" style="margin-left: -.5rem;"></i>
                  <h5 class="card-title mb-0 text-truncate mr-auto placeholder col-6 rounded-pill">
                  </h5>
                  <span class="badge text-capitalize  badge-secondary  badge-primary ">
                    <span class="placeholder col-4"></span>
                  </span>
                </div>
                <div class="card-body px-3 py-2">
                  <section class="markdown-body placeholder-glow" style="background-color: transparent;">
                    <p class="mb-2 placeholder rounded-pill col-4"></p>
                    <p class="mb-2 placeholder rounded-pill col-9"></p>
                    <p class="mb-2 placeholder rounded-pill col-7"></p>
                    <p class="mb-2 placeholder rounded-pill col-5"></p>
                    <p class="placeholder rounded-pill col-3"></p>
                  </section>
                </div>
                <div class="card-footer py-2 small d-flex align-items-center">
                  <span class="px-2 placeholder rounded-pill col-2"></span>
                  <span class="px-2 mr-auto placeholder rounded-pill col-1"></span>
                  <a href="#" class="alert alert-info py-1 mb-0 ml-1" role="alert">
                    <small class="placeholder"></small>
                  </a>
                </div>
              </div>
            </section>
          @show
        @endempty
      </div>
      <aside class="col-3 d-md-none d-lg-block">
        @include('master.includes.main-aside')
      </aside>
    </main>


  </div>
@endsection

@once
  @push('styles')
    {{-- Github Markdown CSS --}}
    <x-style slug="github-markdown-css:5.8.1" />
    {{-- <link rel="stylesheet" type="text/css" href="http://zlyd.iccnconn.com/markdowncss/stylelib/github.css"> --}}
  @endpush
@endonce
@push('scripts')
  <script>
    $(function() {})
  </script>
@endpush
