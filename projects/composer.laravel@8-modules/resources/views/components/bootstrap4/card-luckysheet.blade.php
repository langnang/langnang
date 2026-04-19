@props([
    'name' => null,
    'slug' => null,
    'value' => null,
])

<div class="card card-outline card-info">
  <div class="card-header">
    <h3 class="card-title">
      LuckySheet
    </h3>
  </div>
  <div class="card-body" style="position: relative;height:40vh;">
    <x-jquery.luckysheet :name="$name" :slug="$slug" :value="$value" />
  </div>
  <div class="card-footer">
    Visit <a target="_blank" href="https://dream-num.github.io/LuckysheetDocs/">LuckySheet</a> documentation for more
    examples
    and information about the plugin.
  </div>
</div>
