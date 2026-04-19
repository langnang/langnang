{{-- @props(['module' => '', 'name' => '', 'version' => '', 'file' => '']) --}}
@props(['props' => ['slug', 'alias', 'src', 'version', 'path']])

{{-- @empty($name)
<script type="text/javascript" src="{{ $file }}"></script>
@else
<script type="text/javascript" src="/public/vendor/{{ $name }}/{{ $version }}/{{ $file }}">
</script>
@endempty --}}
@php
  dump($attributes);
  dump($props);
  //   ['module' => '', 'name' => '', 'version' => 'latest', 'file' => ''];
  //   ['module', 'name', 'version', 'file'];
  //   ['name', 'version', 'file'];
  //   ['name', 'file'];
  //   ['file'];
  // $module=empty($module)?'':'/modules/'
  $module = Arr::get($props, 'module');

  $name = Arr::get($props, 'name');

  $version = Arr::get($props, 'version');

  $file = Arr::get($props, 'file');

  if (empty($file)) {
      if (in_array(sizeof($props), [1, 2, 3, 4])) {
          $file = $props[sizeof($props) - 1];
      }
      if (in_array(sizeof($props), [3, 4])) {
          $version = $props[sizeof($props) - 2];
          $name = $props[sizeof($props) - 3];
      }
      if (in_array(sizeof($props), [2])) {
          $name = $props[sizeof($props) - 2];
          $versions = app('files')->directories('public/plugins/' . $name . '/');
          $version = basename($versions[sizeof($versions) - 1]);
          //   var_dump($version);
          //   var_dump(app('files')->directories('public/vendor/' . $name . '/'));
      }
      if (in_array(sizeof($props), [4])) {
          $module = $props[0];
      }
  }

  $path = '';
  if (!empty($module)) {
      $path .= '/modules/' . $module;
  }
  if (!empty($name)) {
      $path .= '/public/plugins/' . $name;
  }
  if (!empty($version)) {
      $path .= '/' . $version;
  }
  if (!empty($file)) {
      $path .= Str::startsWith($file, '/') ? $file : '/' . $file;
  }

  if (!Str::endsWith($path, '.js')) {
      $path .= '.js';
  }
  if (!app('files')->exists(substr($path, 1))) {
      return;
  }
@endphp

@empty($path)
  <noscript type="text/javascript" src="{{ env('APP_URL') }}{{ $path }}"></noscript>
@else
  <script type="text/javascript" src="{{ env('APP_URL') . $path }}"></script>
@endempty
