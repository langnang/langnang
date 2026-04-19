@props([
    'children' => [],
    'selection' => false,
])
<table class="table table-hover">
  <tbody>
    @foreach ($children ?? [] as $child)
      @if (sizeof($child->children ?? []) > 0)
        <tr class="border-0" data-widget="expandable-table" aria-expanded="true">
          <td class="d-flex align-items-center">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="{{ $child->id }}" name="slug">
              <label for="customCheckbox1" class="custom-control-label"></label>
            </div>
            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
            {{ $child->name }}
          </td>
        </tr>
        <tr class="expandable-body">
          <td>
            <div class="p-0">
              <x-admin::master.expandable-table :children="$child->children" :selection="$selection" />
            </div>
          </td>
        </tr>
      @else
        <tr>
          <td class="d-flex align-items-center border-0">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="{{ $child->id }}" name="slug">
              <label for="customCheckbox1" class="custom-control-label"></label>
            </div>
            {{ $child->name }}
          </td>
        </tr>
      @endif
    @endforeach
  </tbody>
</table>
