@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-9">
        <section data-role="content_post-item" lazy-url="{{ url('section') }}?view={{ $alias }}({{ Arr::get($_module, 'meta.id') }})::master:content_item({{ Arr::get($content, 'id') }})">
          {{-- @include('master.sections.content_post-page') --}}
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-2 py-1">
              <li class="breadcrumb-item py-1"><a href="{{ url(isset($_module) ? $_module['alias'] . '/' : 'home/') }}">{{ Arr::get($_module, 'alias', 'Home') }}</a>
              </li>

              <li class="breadcrumb-item py-1 active" aria-current="page">
                <span class="placeholder w-16"></span>
              </li>
              @if (Auth::check())
                {{-- <li class="ml-auto">
                <a class="btn btn-sm btn-warning" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'update-content/' . ($content->id ?? $content->slug)) }}" role="button">Update</a>
                <a class="btn btn-sm btn-danger" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'delete-content/' . ($content->id ?? $content->slug)) }}" role="button">Delete</a>
              </li> --}}
              @endif
            </ol>
          </nav>
          <section class="markdown-body placeholder-glow" style="background-color: transparent;">
            <!--markdown-->
            <h2><span class="placeholder rounded-pill col-5"></span></h2>
            <p><span class="placeholder rounded-pill col-8"></span></p>
            <ul>
              <li><span class="placeholder rounded-pill col-4"></span></li>
              <li><span class="placeholder rounded-pill col-3"></span></li>
              <li><span class="placeholder rounded-pill col-5"></span></li>
            </ul>
            <ol>
              <li><span class="placeholder rounded-pill col-4"></span></li>
              <li><span class="placeholder rounded-pill col-3"></span></li>
              <li><span class="placeholder rounded-pill col-5"></span></li>
            </ol>
            <!--more-->
          </section>
        </section>
      </div>
      <aside class="col-3">
        @include('master.includes.main-aside')
      </aside>
    </div>
  </div>
@endsection

@once
  @push('styles')
    {{-- Github Markdown CSS --}}
    <x-style slug="github-markdown-css:5.8.1" />
    {{-- <link rel="stylesheet" type="text/css" href="http://zlyd.iccnconn.com/markdowncss/stylelib/github.css"> --}}
  @endpush
@endonce
