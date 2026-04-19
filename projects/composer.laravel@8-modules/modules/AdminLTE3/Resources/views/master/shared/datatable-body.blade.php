<table class="table table-sm table-striped table-hover table-head-fixed text-nowrap">
  <thead>
    <tr>
      @foreach ($bodyColumns ?? [] as $column)
        @switch(strtolower($column))
          @case('selection')
            <th class="px-0 text-center" width="14px">#</th>
          @break

          @case('key')
          @case('name')

          @case('title')
          @case('migration')
            <th>{{ Str::studly($column) }}</th>
          @break

          @case('roles')
          @case('email')
            <th class="text-center">{{ Str::studly($column) }}</th>
          @break

          @case('children_count')
            <th class="text-center" width="70px">Children</th>
          @break

          @case('relationships_count')
            <th class="text-center" width="70px">Relations</th>
          @break

          @case('type')
          @case('status')

          @case('order')
          @case('batch')
            <th class="text-center" width="60px">{{ Str::studly($column) }}</th>
          @break

          @case('created_at')
          @case('updated_at')

          @case('release_at')
          @case('deleted_at')

          @case('expiration')
            <th class="text-center" width="150px">{{ Str::studly($column) }}</th>
          @break

          @default
          @break
        @endswitch
      @endforeach
    </tr>
  </thead>
  <tbody>
    @if ($errors->any())
      <tr>
        <td class="alert alert-danger alert-dismissible mb-0" colspan="{{ sizeof($bodyColumns ?? []) }}">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-ban"></i> Alert!</h5>
          Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
          entire
          soul, like these sweet mornings of spring which I enjoy with my whole heart.
        </td>
      </tr>
    @endif
    @foreach ($paginator ?? [] as $index => $item)
      <tr>
        @foreach ($bodyColumns ?? [] as $column)
          @switch(strtolower($column))
            @case('selection')
              <td class="pl-2 text-center">
                <div class="form-check">
                  <input class="form-check-input" name="paginator[{{ $index }}][id]" type="checkbox" value="{{ $item->{$primaryKey ?? 'id'} }}">
                </div>
              </td>
            @break

            @case('key')
            @case('name')

            @case('title')
            @case('migration')
              <td>
                <a class="d-inline-block text-truncate" name="paginator[{{ $index }}][{{ $column }}]" href="{{ Str::plural($slug) }}/{{ $item->{$primaryKey ?? 'id'} }}">
                  @if (property_exists($item, 'type') && Str::startsWith($item->type, 'draft-'))
                    <span class="badge badge-secondary">Draft</span>
                  @endif
                  {{ $item->{$column} }}
                </a>
              </td>
            @break

            @case('roles')
            @case('email')
              <td class="text-center" name="paginator[{{ $index }}][{{ $column }}]">{{ Arr::get($item, $column, $item->{$column}) }}</td>
            @break

            @case('children_count')
              <td class="text-center">
                @if (in_array($item['type'], ['module', 'category']))
                  <a class="" name="paginator[{{ $index }}][{{ $column }}]" href="{{ Str::plural($slug) }}?parent={{ $item->{$primaryKey ?? 'id'} }}">{{ $item['children_count'] }}</a>
                @else
                  -
                @endif
              </td>
            @break

            @case('relationships_count')
              <td class="text-center">
                <a class="" name="paginator[{{ $index }}][{{ $column }}]" href="#" data-href="{{ url('admin/relationship?iframe&') . $slug }}_id={{ $item->id }}" data-toggle="modal" data-target="#iframeModal">{{ $item['relationships_count'] }}</a>
              </td>
            @break

            @case('expiration')
              <td class="text-center" name="paginator[{{ $index }}][{{ $column }}]">{{ date('Y-m-d h:i:s', $item->{$column}) }}</td>
            @break

            @default
              <td class="text-center" name="paginator[{{ $index }}][{{ $column }}]">{{ Arr::get($item, $column, $item->{$column}) }}</td>
          @endswitch
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>
