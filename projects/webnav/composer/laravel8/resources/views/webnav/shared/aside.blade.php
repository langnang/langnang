<aside class="sidebar-menu toggle-others fixed">
  <div class="sidebar-menu-inner">
    <header class="logo-env">
      <!-- logo -->
      <div class="logo">
        <a href="./" class="logo-expanded">
          <img src="/public/images/webstack/logo@2x.png" width="100%" alt="" />
        </a>
        <a href="./" class="logo-collapsed">
          <img src="/public/images/webstack/logo-collapsed@2x.png" width="40" alt="" />
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
    @section('sidebar')
      <ul id="main-menu" class="main-menu">
        @isset($tree)
          @foreach ($tree ?? [] as $category)
            @php
              $hasChildren = count($category->children ?? []) > 0;
            @endphp
            <li>
              <a href="#{{ $category->name }}" class="{{ $hasChildren ? '' : 'smooth' }}">
                <i class="{{ $category->ico }}"></i>
                <span class="title">{{ $category->name }}</span>
              </a>

              @if ($hasChildren)
                <ul>
                  @foreach ($category->children as $sub)
                    <li>
                      <a href="#{{ $sub['name'] }}" class="smooth">
                        <span class="title">{{ $sub['name'] }}</span>
                        @if (isset($sub['hot']) && $sub['hot'])
                          <span class="label label-pink pull-right hidden-collapsed">Hot</span>
                        @endif
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        @endisset
        <li>
          <a href="./about">
            <i class="linecons-heart"></i>
            <span class="tooltip-blue">关于本站</span>
            <span class="label label-Primary pull-right hidden-collapsed">♥︎</span>
          </a>
        </li>
        <li>
          <a href="/webstack/content/insert">
            <i class="fa-circle-plus"></i>
            站点收录
          </a>
        </li>
      </ul>
    @show
  </div>
</aside>
