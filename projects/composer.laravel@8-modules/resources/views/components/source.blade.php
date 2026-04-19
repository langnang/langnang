@props([
    'slug' => null,
    'src' => null, // 远程路径
    'path' => null, // 本地路径
    'public_path' => null,
    'module' => null,
    'module_path' => null,
])
@php
  // dump($attributes);
  // dump($path);
  // dump(app_path($path));
  // dump(File::exists(app_path($path)));
  if ($path || $public_path || $module_path) {
      $base_path = $path ?? ($public_path ? 'public/' . $public_path : null);
      $_path = $base_path ? base_path($base_path) : module_path($module, $module_path);
      // dump(base_path());
      // dump($_path);
      // dump(dirname($app_path));
      // dump(dirname($_path));
      if (!File::exists($_path) && $src) {
          // File::makeDirectory(dirname($app_path));
          File::isDirectory(dirname($_path)) or File::makeDirectory(dirname($_path), 0777, true, true);
          copy($src, $_path);
          // Storage::copy($src, basename($_path));
          //   $_src_content = Http::get($src);
          //   dump($_src_content);
          //   File::puh(app_path($path), file_get_contents($src));
      }
      $localSrc = asset(substr($_path, strlen(base_path('')) + 1));
  }
  // dump($src);
@endphp

@empty($localSrc ?? $src)
@else
  <source style="display: none;" src="{{ $localSrc ?? $src }}" data-href="{{ $src }}">
@endempty
