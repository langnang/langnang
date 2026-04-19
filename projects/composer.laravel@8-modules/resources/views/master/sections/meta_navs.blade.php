@php
  $associated_navs = select_list([
      '$model' => \App\Models\Meta::class,
      '$with' => ['children'],
      '$where' => [
          ['type', 'nav'],
          [
              'parent',
              $_moduleId ??
              select_item([
                  '$model' => \App\Models\Meta::class,
                  '$where' => [['type', 'module'], ['slug', 'module:' . $_moduleAlias]],
              ])->id,
          ],
      ],
      '$orderBy' => ['order', 'asc'],
  ]);
@endphp
@if (config($_moduleAlias . '.view.showSidebar'))
  <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
  </li>
@endif
<li class="nav-item d-sm-inline-block active">
  <a href="{{ url($_moduleAlias) }}" class="nav-link">{{ $_moduleAlias }}</a>
</li>
@foreach ($associated_navs as $nav)
  <li class="nav-item d-sm-inline-block active">
    <a href="{{ url($_moduleAlias) }}/nav/{{ $nav['id'] }}" class="nav-link">{{ $nav['name'] }}</a>
  </li>
@endforeach
