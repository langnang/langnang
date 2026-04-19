@extends('layout')


@section('content')
  @isset($contents)
    @foreach ($contents as $panel)
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $panel['name'] }}</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            @isset($panel['contents'])
              @foreach ($panel['contents'] as $content)
                <div class="col-sm-4 col-md-3" style="padding: 0 5px;">
                  <a class="thumbnail" style="margin-bottom: 10px;"
                    @isset($content['slug'])
                       href="/{{ str_replace('_', '/', $content['slug']) }}"
                    @endisset>
                    <div class="caption">
                      <h4>{{ $content['title'] }}</h4>
                    </div>
                  </a>
                </div>
              @endforeach
            @endisset
          </div>
        </div>
      </div>
    @endforeach
  @endisset
@endsection
