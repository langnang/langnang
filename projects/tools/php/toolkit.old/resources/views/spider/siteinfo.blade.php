@extends('layout')

@section('content')
  <form class="form-horizontal" method="post" action="/spider/siteinfo">
    @csrf
    <div class="form-group">
      <label for="Url" class="col-sm-2 control-label">URL</label>
      <div class="col-sm-10">
        <div class="input-group">
          <input type="text" class="form-control" name="url" placeholder="Url"
            value="{{ isset($data['url']) ? $data['url'] : '' }}">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit">Submit</button>
          </span>
        </div>
      </div>
    </div>
  </form>
  <hr>
  @php
    use phpspider\core\requests;
    use phpspider\core\selector;
  @endphp
  @isset($data['url'])
    @php
      $url = $data['url'];
      $html = requests::get($url);
      $title = selector::select($html, '//head//title');
      $metas = [];
      for ($i = 0; $i < count(selector::select($html, '//head//meta')) + 1; $i++) {
          $name = selector::select($html, "//head//meta[$i]/@name");
          $content = selector::select($html, "//head//meta[$i]/@content");
          if (empty($name) || empty($content)) {
              continue;
          }
          array_push($metas, [
              'name' => $name,
              'content' => $content,
          ]);
      }
      $icos = selector::select($html, "//head//link[contains(@rel,'icon')]/@href");
    @endphp
    <form class="">
      <div class="form-group">
        <label for="title" class="control-label">title</label>
        <p class="form-control-static">{{ $title }}</p>
      </div>
      <div class="form-group">
        <label for="ico" class="control-label">ico</label>
        <p class="form-control-static">{{ $icos }}</p>
      </div>
      <div class="form-group">
        <label for="metas" class="control-label">metas</label>
        <div>

          <dl class="dl-horizontal">
            @foreach ($metas as $meta)
              <dt>{{ $meta['name'] }}</dt>
              <dd>{{ $meta['content'] }}</dd>
            @endforeach
          </dl>
        </div>
      </div>
    </form>
    <hr>
  @endisset
@endsection
