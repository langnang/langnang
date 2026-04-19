@php
  $_layout = $_layout ?? [];
  $_layout['header'] = [
      'data' => [
          'navs' => array_merge(
              [
                  [
                      'name' => strtoupper($prefix),
                      'url' => "/{$prefix}",
                  ],
              ],
              array_map(
                  function ($item, $index) use ($prefix) {
                      // dump($item);
                      // dump($prefix);
                      // dump('/content/' . $item['mid']);
                      $item['url'] = '/' . $prefix . '/meta/' . $index;
                      return $item;
                  },
                  $categories->toArray(),
                  array_keys($categories->toArray()),
              ),
              [['name' => '提交收录', 'ico' => 'bi bi-plus-lg', 'url' => "/{$prefix}/content-form/0"]],
          ),
      ],
  ];
  $_layout['aside'] = ['data' => $tree['children']];
  $_layout["$prefix"] = ['extends' => '_layout.sidebar'];
  $_layout["$prefix/meta/{mid}"] = ['extends' => '_layout.sidebar'];
@endphp

@extends('_layout.auto')

@section('scripts')
  <script>
    $(document).ready(function() {
      //img lazy loaded
      const observer = lozad();
      observer.observe();
    })
  </script>
@endsection
