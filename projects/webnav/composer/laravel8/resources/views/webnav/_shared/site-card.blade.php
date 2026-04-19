@php
  
@endphp
<a class="card card-sm text-body text-decoration-none" href="{{ $data['slug'] }}" target="_blank" data-toggle="tooltip"
  data-placement="bottom" title="{{ $data['slug'] }}">
  <div class="card-body pl-1 pr-1">
    <div class="media">
      @empty($data['ico'])
        <img src="holder.js/48x48" class="img-circle img-thumbnail align-self-center mr-2" width="48">
      @else
        @php
          $expl = explode(' ', $data['ico']);
          $len = sizeof($expl);
        @endphp
        @if ($len == 1)
          <img data-src="{{ $data['ico'] }}" class="lozad img-circle img-thumbnail align-self-center mr-2"
            width="48">
        @elseif($len == 2)
          <i class="{{ $data['ico'] }} mr-2" width="48"></i>
        @endif
      @endempty
      {{-- @if ($data['type'] == 'data')
                          <img data-src="{{ $data['ico'] }}" class="lozad img-circle img-thumbnail align-self-center mr-3"
                            width="48">
                        @elseif ($data['type'] == 'icon')
                          <i class="{{ $data['ico'] }}"></i>
                        @else
                          <img data-src="holder.js/48x48" class="lozad img-circle img-thumbnail align-self-center mr-3"
                            width="48">
                        @endif --}}
      <div class="media-body" style="width: calc(100% - 48px - 1rem);">
        <h5 class="mt-0 text-truncate">{{ isset($data['title']) ? $data['title'] : $data['ico'] }}</h5>
        <p class="small mb-0 text-wrap text-truncate" style="height: 40px;">
          {{ $data['text'] }}</p>
      </div>
    </div>
  </div>
</a>
