@props([
    'name' => null,
    'slug' => null,
    'value' => null,
])

<div class="card card-outline card-info">
  <div class="card-header">
    <h3 class="card-title">
      CodeMirror
    </h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <x-jquery.codemirror :name="$name" :slug="$slug" :value="$value" />
  </div>
  <div class="card-footer">
    Visit <a target="_blank" href="https://codemirror.net/">CodeMirror</a> documentation for more examples and information
    about the plugin.
  </div>
</div>
