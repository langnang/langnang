@php
  $associated_categories = select_list([
      '$model' => \App\Models\Meta::class,
      '$with' => ['children'],
      '$where' => [
          ['type', 'category'],
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

@foreach ($associated_categories as $category)
  <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: .9rem;">
    <a class="text-truncate mr-auto" href="{{ url($_moduleAlias . '/meta/' . ($category->id ?? $category->slug)) }}" title="{{ $category->name }}">{{ $category->name }}</a>
    @if (Auth::check())
      {{-- <a class="bi ml-1 bi-pen" href="{{ url($_moduleAlias . '/update-meta/' . ($category->id ?? $category->slug)) }}"></a> --}}
    @endif
  </li>
  @foreach ($category['children'] ?? [] as $child)
    <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.2rem;">
      <a class="text-truncate mr-auto" href="{{ url($_moduleAlias . '/meta/' . ($child->id ?? $child->slug)) }}" title="{{ $child->name }}">{{ $child->name }}</a>
      @if (Auth::check())
        {{-- <a class="bi ml-1 bi-pen" href="{{ url($_moduleAlias . '/update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
      @endif
    </li>
    @foreach ($child['children'] ?? [] as $child_01)
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.5rem;">
        <a class="text-truncate mr-auto" href="{{ url($_moduleAlias . '/meta/' . ($child_01->id ?? $child_01->slug)) }}" title="{{ $child_01->name }}">{{ $child_01->name }}</a>
        @if (Auth::check())
          {{-- <a class="bi ml-1 bi-pen" href="{{ url($_moduleAlias . '/update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
        @endif
      </li>
      @foreach ($child_01['children'] ?? [] as $child_02)
        <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.8rem;">
          <a class="text-truncate mr-auto" href="{{ url($_moduleAlias . '/meta/' . ($child_02->id ?? $child_02->slug)) }}" title="{{ $child_02->name }}">{{ $child_02->name }}</a>
          @if (Auth::check())
            {{-- <a class="bi ml-1 bi-pen" href="{{ url($_moduleAlias . '/update-meta/' . ($child->id ?? $child->slug)) }}"></a> --}}
          @endif
        </li>
      @endforeach
    @endforeach
  @endforeach
@endforeach
