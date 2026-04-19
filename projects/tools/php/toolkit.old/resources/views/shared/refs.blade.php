<div class="panel panel-default">
  <div class="panel-heading">参考文献</div>
  <div class="panel-body">
    <ul class="list-inline">
      @foreach ($refs as $link)
        <li> <a target="_blank" href="{{ $link['url'] }}">{{ $link['title'] }}</a> </li>
      @endforeach
    </ul>
  </div>
</div>
</div>
