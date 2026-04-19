@props([
    'name' => null,
    'slug' => \Faker\Factory::create()->slug,
    'value' => null,
    'title' => null,
    'description' => null,

    'mode' => null,
    'theme' => 'primary',
    'outline' => true,

    'selection' => false,

    'collapse' => false,
    'collapseShow' => true,

    'full' => false,

    'header' => true,
    'headRight' => null,
    'headShow' => true,
    'headClass' => null,
    'headStyle' => null,

    'bodyClass' => null,
    'bodyStyle' => null,

    'footer' => true,
    'footerShow' => true,
    'footerClass' => null,
    'footerStyle' => null,

    'slotHead' => null,
    'slotHeadRight' => null,
    'slotFoot' => null,
])

<div class="card card-{{ $theme }} @if ($outline) card-outline @endif">
  @if ($header)
    <div class="card-header text-dark d-flex align-items-center py-2" style="padding-right: 3.5rem;">
      @if ($selection)
        <div class="custom-control custom-checkbox">
          <input class="custom-control-input" type="checkbox" value="{{ $slug }}" name="slug">
          <label for="customCheckbox1" class="custom-control-label"></label>
        </div>
      @endif
      @if ($title)
        <a class="card-title h3 w-100 mr-auto" data-toggle="collapse" href="#card-{{ $slug }}">
          {{ $title }}
          @if ($description)
            <small class="text-muted">{{ $description }}</small>
          @endif
        </a>
      @endif
      {{ $slotHeadRight }}
    </div>
  @else
  @endif
  <div class="collapse @if ($collapseShow) show @endif" id="card-{{ $slug }}">
    <div class="card-body p-2">
      {{ $slot }}
    </div>
    @if ($footer)
      <div class="card-footer">
        {{ $slotFoot }}
      </div>
    @endif
  </div>
</div>
