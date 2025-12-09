<div class="sidebar-menu toggle-others fixed">
  <div class="sidebar-menu-inner">
    <header class="logo-env">
      <div class="logo">
        <a href="/" class="logo-expanded">
          <img src="{{ asset('webstack/img/logo@2x.copy.png') }}" width="100%" alt=""/>
        </a>
        <a href="/" class="logo-collapsed">
          <img src="{{ asset('webstack/img/logo-collapsed@2x.png') }}" width="40" alt=""/>
        </a>
      </div>
      <div class="mobile-menu-toggle visible-xs">
        <a href="#" data-toggle="user-info-menu">
          <i class="linecons-cog"></i>
        </a>
        <a href="#" data-toggle="mobile-menu">
          <i class="fa-bars"></i>
        </a>
      </div>
    </header>
    <ul id="main-menu" class="main-menu">
      @foreach ($categories as $categorie)
        <li>
          @if ($categorie->children_count == 0)
            <a href="#{{ $categorie->name }}" class="smooth">
              <i class="fa fa-fw {{ $categorie->ico }}"></i>
              <span class="title">{{ $categorie->name }}</span>
            </a>
          @elseif ($categorie->children_count != 0 )
            <a>
              <i class="fa fa-fw {{ $categorie->ico }}"></i>
              <span class="title">{{ $categorie->name }}</span>
            </a>
            <ul>
              @foreach ($categorie->children as $child)
                <li>
                  <a href="#{{ $child->name }}" class="smooth">
                    <span class="title">{{ $child->name }}</span>
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </li>
      @endforeach

      <li class="submit-tag">
        <a href="/about">
          <i class="linecons-heart"></i>
          <span class="tooltip-blue">关于本站</span>
          <span class="label label-Primary pull-right hidden-collapsed">♥︎</span>
        </a>
      </li>
    </ul>
  </div>
</div>
