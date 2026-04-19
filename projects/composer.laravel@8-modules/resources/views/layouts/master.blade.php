{{-- @extends('home::layouts.master')

@section('content')
<h1>Hello World</h1>

<p>
  This view is loaded from module: {!! config('home.name') !!}
</p>
@endsection --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', Arr::get($_module ?? [], 'name')) | {{ env('APP_NAME') }}</title>

  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <x-style slug="normalize.css:8.0.1" />

  <!-- Font Awesome -->
  <x-style
    slug="@fortawesome/fontawesome-free:6.5.1" />

  {{--
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> --}}
  <!-- Ionicons -->
  <x-style slug="ionicons:2.0.1" />
  {{--
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Tempusdominus Bootstrap 4 -->
  {{--
  <x-style slug="tempusdominus-bootstrap-4:5.39.0" /> --}}
  {{--
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> --}}
  <!-- iCheck -->
  {{-- icheck-bootstrap:3.0.1 --}}
  {{--
  <x-style slug="icheck-bootstrap:3.0.1" /> --}}
  {{--
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
  <!-- JQVMap -->
  {{-- jqvmap:1.5.1 --}}
  <x-style slug="icheck-bootstrap:3.0.1" />
  {{--
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> --}}
  <!-- Theme style -->
  {{-- admin-lte:3.2.0 --}}
  <x-style slug="admin-lte:3.2.0"></x-style>
  {{--
  <link rel="stylesheet" href="dist/css/adminlte.min.css"> --}}
  <!-- overlayScrollbars -->
  {{-- overlayScrollbars:1.13.0 --}}
  {{--
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}
  <!-- Daterange picker -->
  {{-- daterangepicker:3.1 --}}
  {{--
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css"> --}}
  <!-- summernote -->
  {{-- summernote:0.8.20 --}}
  {{--
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css"> --}}

  @stack('pluginStyles')

  <style>
    .main-header .nav-link {
      height: auto;
    }

    .sidebar-mini .xdebug-var-dump {
      transition: margin-left .3s ease-in-out;
      margin-left: 250px;
    }

    .sidebar-mini.sidebar-collapse .xdebug-var-dump {
      margin-left: 4.6rem !important
    }

    .nav-sidebar .nav-treeview .nav-link {
      padding-left: 1.5rem;
    }

    .nav-sidebar .nav-treeview .nav-treeview .nav-link {
      padding-left: 2rem;
    }

    .card-title {
      font-size: 1.3rem;
    }

    .pagination {
      margin-bottom: 0;
    }


    .input-group-sm>.custom-file,
    .input-group-sm>.custom-file>.custom-file-input,
    .input-group-sm>.custom-file>.custom-file-label,
    .input-group-sm>.custom-file>.custom-file-label::after {
      height: calc(1.8125rem + 2px);
      padding: .25rem .5rem;
      font-size: .875rem;
    }
  </style>

  <link rel="stylesheet" href="{{ asset('public/master/css/style.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('public/master/css/app.css') }}"> --}}

  @stack('styles')

</head>

<body class="hold-transition sidebar-mini layout-fixed bg-gray-100 dark:bg-gray-900">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar sticky-top navbar-expand navbar-white navbar-light align-items-center">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center" lazy-url="{{ url('section') }}?view={{ $alias }}({{ Arr::get($_module, 'meta.id') }})::master:meta_navs&{{ Arr::query(request()->all()) }}">
      @if (Arr::get($_module, 'configs.view.showSidebar'))
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @endif
      <li class="nav-item d-sm-inline-block active">
        <a href="{{ url($_module['alias']) }}" class="nav-link">{{ $_module['name'] }}</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav align-items-center ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline m-0">
            <div class="input-group input-group">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown d-none">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              {{-- <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle"> --}}
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              {{-- <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3"> --}}
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              {{-- <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3"> --}}
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown d-none">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ env('APP_URL') }}">Welcome <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown d-none">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link disabled">Disabled</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Modules
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          @foreach (Module::allEnabled() ?? [] as $attributesName => $attributesObject)
          @if (Auth::check() || config($attributesObject->getLowerName() . '.status', 'public') == 'public')
          <a class="dropdown-item px-2 small"
            href="{{ env('APP_URL') }}{{ $attributesObject->getLowerName() ?? strtolower($attributesName) }}">{{ config($attributesObject->getLowerName() . '.nameCn') }}·{{ $attributesName }}</a>
          @endif @endforeach
        </div>
      </li>
      @if (Auth::check())
      <li class="nav-item
    dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
      {{-- <img src="{{ Auth::user()->ico }}" alt="" height="19px"> --}}
      {{ Auth::user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

      <a class="dropdown-item small px-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="bi bi-asterisk"></i> {{ __('Logout') }}
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
    </li>
  @else
    @if (Route::has('login'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
    @endif

    @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
    @endif
    @endif

    </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @if (Arr::get($_module, 'configs.view.showSidebar'))
      <aside class="main-sidebar sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link text-center" style="overflow: hidden;">
          {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8"> --}}
          <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>
        <x-master.sidebar />
      </aside>
    @else
      <aside class="main-sidebar sidebar-dark-primary" style="height: 57px;">
        <!-- Brand Logo -->
        <a href="{{ env('APP_URL') }}" class="brand-link text-center" style="overflow: hidden;">
          {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8"> --}}
          <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>
      </aside>
    @endif


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pb-2" @unless (Arr::get($_module, 'configs.view.showSidebar')) style="margin-left: 0!important; height:unset;" @endunless>
      @yield('content')
    </div>

    <footer class="main-footer" @unless (Arr::get($_module, 'configs.view.showSidebar')) style="margin-left: 0!important;" @endunless>
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->


    <!-- jQuery -->
    {{-- jquery:3.7.1 --}}
    <x-script slug="jquery:3.7.1"></x-script>
    {{-- <script src="plugins/jquery/jquery.min.js"></script> --}}
    <!-- jQuery UI 1.11.4 -->
    {{-- jquery-ui:1.13.0 --}}
    <x-script slug="jquery-ui:1.13.0"></x-script>
    {{-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> --}}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    {{-- bootstrap:4.6.2 --}}
    <x-script slug="bootstrap:4.6.2"></x-script>
    {{-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <!-- ChartJS -->
    {{-- chart.js:2.9.4 --}}
    {{-- <script src="plugins/chart.js/Chart.min.js"></script> --}}
    <!-- Sparkline -->
    {{-- <script src="plugins/sparklines/sparkline.js"></script> --}}
    <!-- JQVMap -->
    {{-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script> --}}
    {{-- <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
    <!-- jQuery Knob Chart -->
    {{-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> --}}
    <!-- daterangepicker -->
    {{-- <script src="plugins/moment/moment.min.js"></script> --}}
    {{-- <script src="plugins/daterangepicker/daterangepicker.js"></script> --}}
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> --}}
    <!-- Summernote -->
    {{-- <script src="plugins/summernote/summernote-bs4.min.js"></script> --}}
    <!-- overlayScrollbars -->
    {{-- <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
    <!-- AdminLTE App -->
    {{-- admin-lte:3.2.0 --}}
    <x-script slug="admin-lte:3.2.0"></x-script>
    {{-- <script src="dist/js/adminlte.js"></script> --}}


    @stack('pluginScripts')

    <script src="{{ asset('public/master/js/script.js') }}"></script>

    @stack('scripts')


    </body>

</html>
