@php
  variable(basename(__FILE__), [$tree]);
@endphp
@extends('webstack.layout')

@section('main')
  @foreach ($tree as $category)
    @if (count($category->contents) > 0)
      <div class="card" id="{{ $category['name'] }}">
        <h4 class="text-gray">
          <i class="linecons-tag" style="margin-right: 7px;"></i>
          {{ $category['name'] }}
        </h4>
        <div class="row">
          @foreach ($category->contents as $site)
            <div class="col-xs-6 col-md-3">
              <div class="xe-widget xe-conversations box2 label-info"
                @isset($site['url'])
                           onclick="window.open('{{ $site['url'] }}', '_blank')"
                           @endisset
                data-toggle="tooltip" data-placement="bottom" title=""
                data-original-title="{{ isset($site['url']) ? $site['url'] : $site['ico'] }}">
                <div class="xe-comment-entry">
                  <div class="xe-user-img">
                    @if ($site['type'] == 'site')
                      <img data-src="{{ $site['ico'] }}" class="lozad img-circle img-thumbnail" width="48">
                    @elseif ($site['type'] == 'icon')
                      <i class="{{ $site['ico'] }}"></i>
                    @endif
                  </div>
                  <div class="xe-comment">
                    <div class="xe-user-name overflowClip_1">
                      <strong>{{ isset($site['title']) ? $site['title'] : $site['ico'] }}</strong>
                    </div>
                    <p class="overflowClip_2">{{ isset($site['text']) ? $site['text'] : '' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
    @if (count($category->children) > 0)
      @foreach ($category->children as $subCategory)
        <div class="card" id="{{ $subCategory['name'] }}">
          <h4 class="text-gray">
            <i class="linecons-tag" style="margin-right: 7px;"></i>
            {{ $subCategory['name'] }}
          </h4>
          <div class="row">
            @foreach ($subCategory->contents as $site)
              <div class="col-sm-3">
                <div class="xe-widget xe-conversations box2 label-info"
                  @isset($site['url'])
                    onclick="window.open('{{ $site['url'] }}', '_blank')"
                  @endisset
                  data-toggle="tooltip" data-placement="bottom" title=""
                  data-original-title="{{ isset($site['url']) ? $site['url'] : $site['ico'] }}">
                  <div class="xe-comment-entry">
                    <div class="xe-user-img">
                      @if ($site['type'] == 'site')
                        <img data-src="{{ $site['ico'] }}" class="lozad img-circle img-thumbnail" width="48">
                      @elseif ($site['type'] == 'icon')
                        <i class="{{ $site['ico'] }}"></i>
                      @endif
                    </div>
                    <div class="xe-comment">
                      <div href="#" class="xe-user-name overflowClip_1">
                        <strong>{{ isset($site['title']) ? $site['title'] : $site['ico'] }}</strong>
                      </div>
                      <p class="overflowClip_2">{{ isset($site['text']) ? $site['text'] : '' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    @endif
  @endforeach
@endsection
