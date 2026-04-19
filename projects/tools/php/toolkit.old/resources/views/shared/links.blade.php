<div class="panel panel-default">
  <div class="panel-heading">友情链接</div>
  <div class="panel-body">
    <ul class="list-inline">
      @foreach ($links as $link)
        <li> <a target="_blank" href="{{ $link['url'] }}">{{ $link['title'] }}</a> </li>
      @endforeach
    </ul>
  </div>
</div>
</div>
