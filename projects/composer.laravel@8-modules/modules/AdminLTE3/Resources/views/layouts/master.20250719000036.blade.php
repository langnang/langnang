<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <x-style :path="'public/plugins/@fortawesome/fontawesome-free/6.5.1/css/all.min.css'"/>
  <!-- Ionicons -->
  <x-style path="public/plugins/ionicons/2.0.1/css/ionicons.min.css" src="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
  <!-- Tempusdominus Bootstrap 4 -->
  <x-style rel="stylesheet" path="public/plugins/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"/>
  <!-- iCheck -->
  <x-style rel="stylesheet" path="public/plugins/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"/>
  <!-- JQVMap -->
  <x-style rel="stylesheet" path="public/plugins/jqvmap/1.5.1/jqvmap.min.css"/>
  <!-- Theme style -->
  <x-style rel="stylesheet" path="public/plugins/admin-lte/3.2.0/css/adminlte.min.css"/>
  <!-- overlayScrollbars -->
  <x-style rel="stylesheet" path="public/plugins/overlayScrollbars/1.13.0/css/OverlayScrollbars.min.css"/>
  <!-- Daterange picker -->
  <x-style rel="stylesheet" path="public/plugins/daterangepicker/3.1/daterangepicker.css"/>
  <!-- summernote -->
  <x-style rel="stylesheet" path="public/plugins/summernote/0.8.20/summernote-bs4.min.css"/>
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
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center d-none">
      <img class="animation__shake" path="public/plugins/admin-lte/3.2.0/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>


    @section('main')
      <div class="wrapper">
        {{-- @section('preloader') @include('adminlte::layouts.preloader') @show --}}
        @section('navbar') @include('admin::master.shared.navbar') @show
        @section('sidebar') @include('admin::master.shared.sidebar') @show
        <!-- Content Wrapper. Contains page content -->
        <div class="container-flud content-wrapper" @if (!request()->filled('iframe')) style="height: calc(100vh - 114px); overflow-y: auto; min-height: auto;" @endif>
          <!-- Content Header (Page header) -->
          <div class="content-header px-3 d-flex align-items-center py-2">

            <h1 class="m-0 mr-auto">{{ Arr::get($_module, 'active_category.name', 'Dashboard') }}

              <small class="text-muted"><em>{{ Arr::get($_module, 'active_category.description') }}</em> </small>
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              @foreach (Arr::get($_module, 'categories', []) as $category)
                @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category['slug'])))
                  <li class="breadcrumb-item"><a href="{{ url(Str::replace(':', '/', $category['slug'])) }}">{{ $category['name'] }}</a></li>
                @endif
                @foreach (Arr::get($category, 'children', []) as $category_child)
                  @if (Str::startsWith(request()->path(), Str::replace(':', '/', $category_child['slug'])))
                    <li class="breadcrumb-item"><a href="{{ url(Str::replace(':', '/', $category_child['slug'])) }}">{{ $category_child['name'] }}</a>
                    </li>
                  @endif @endforeach
                                                                            @endforeach
    {{-- @foreach ($_module['menu_actives'] ?? [] as $menu_item)
                @if ($loop->last)
                  <li class="breadcrumb-item active">{{ $menu_item['title'] }}</li>
                @else
                  <li class="breadcrumb-item"><a href="{{ $menu_item['path'] }}">{{ $menu_item['title'] }}</a></li>
                @endif
              @endforeach --}}
    </ol>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @section('footer') @include('admin::master.shared.footer') @show
    @section('control-sidebar') @include('admin::master.shared.control-sidebar') @show
    </div>
  @show
  <x-admin::master.modal-iframe />
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <x-script slug='jquery' path="public/plugins/jquery/3.7.1/jquery.min.js" src="https://unpkg.com/jquery@3.7.1/dist/jquery.min.js" />
  {{-- <script src="public/plugins/jquery/jquery.min.js"></script> --}}
  <!-- jQuery UI 1.11.4 -->
  <x-script path="public/plugins/jquery-ui/1.13.0/jquery-ui.min.js"></x-script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <x-script path="public/plugins/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></x-script>
  <!-- ChartJS -->
  <x-script path="public/plugins/chart.js/2.9.4/Chart.min.js"></x-script>
  <!-- Sparkline -->
  <x-script path="public/plugins/sparklines/sparkline.js"></x-script>
  <!-- JQVMap -->
  <x-script path="public/plugins/jqvmap/1.5.1/jquery.vmap.min.js"></x-script>
  <x-script path="public/plugins/jqvmap/1.5.1/maps/jquery.vmap.usa.js"></x-script>
  <!-- jQuery Knob Chart -->
  <x-script path="public/plugins/jquery-knob/jquery.knob.min.js"></x-script>
  <!-- daterangepicker -->
  <x-script path="public/plugins/moment/2.30.1/moment.min.js"></x-script>
  <x-script path="public/plugins/daterangepicker/3.1/daterangepicker.js"></x-script>
  <!-- Tempusdominus Bootstrap 4 -->
  <x-script path="public/plugins/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></x-script>
  <!-- Summernote -->
  <x-script path="public/plugins/summernote/0.8.20/summernote-bs4.min.js"></x-script>
  <!-- overlayScrollbars -->
  <x-script path="public/plugins/overlayScrollbars/1.13.0/js/jquery.overlayScrollbars.min.js"></x-script>
  <!-- AdminLTE App -->
  <x-script path="public/plugins/admin-lte/3.2.0/js/adminlte.js"></x-script>
  <!-- AdminLTE for demo purposes -->
  <x-script path="public/master/js/adminlte.demo.js"></x-script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  {{-- <script src="public/js/pages/dashboard.js"></script> --}}

  @stack('scripts')
  </body>

</html>
