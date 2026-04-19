<header class="navbar user-info-navbar" role="navigation">
  <!-- User Info, Notifications and Menu Bar -->
  <!-- Left links for user info navbar -->
  <ul class="user-info-menu left-links list-inline list-unstyled">
    <li class="hidden-sm hidden-xs">
      <a href="#" data-toggle="sidebar">
        <i class="fa-bars"></i>
      </a>
    </li>
    @foreach ($branches as $branch)
      <li class="hidden-sm hidden-xs hover-line">
        <a href="{{ $prefix }}/{{ $branch->slug }}">
          <i class="{{ $branch->ico }}"></i>
          {{ $branch->name }}
        </a>
      </li>
    @endforeach
  </ul>
  <ul class="user-info-menu right-links list-inline list-unstyled">
    @empty(config('view.routes'))
    @else
      @foreach (config('view.routes') as $route)
        <li class="hidden-sm hidden-xs">
          <a href="{{ $route['path'] }}">
            {{ $route['name'] }}
          </a>
        </li>
      @endforeach

    @endempty
  </ul>
  <!-- <a href="https://github.com/WebStackPage/WebStackPage.github.io" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a> -->
</header>
