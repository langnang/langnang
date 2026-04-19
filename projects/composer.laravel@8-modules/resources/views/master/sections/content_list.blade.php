@foreach ($posts as $post)
  <div class="card my-2 @switch($post->status) @case('public') border-secondary @case('publish') border-primary @break @case('protect') border-warning @break @case('private') border-danger @break @default @break @endswitch">
    <div class="card-header d-flex align-items-center">
      <i class="bi bi-circle-fill mr-2 @switch($post->status) @case('public') text-secondary @case('publish') text-primary @break @case('protect') text-warning @break @case('private') text-danger @break @default @break @endswitch" data-toggle="tooltip" data-placement="right" title="{{ $post->status }}" style="margin-left: -.5rem;"></i>
      <h5 class="card-title mb-0 text-truncate mr-auto">
        {{ $post->title }}
      </h5>
      <span class="badge text-capitalize @switch($post->status) @case('public') badge-secondary @case('publish') badge-primary @break @case('protect') badge-warning @break @case('private') badge-danger @break @default @break @endswitch">{{ $post->status }}</span>
      {{-- <button type="button" class="btn btn-sm mx-1 btn-primary">Primary</button>
                <button type="button" class="btn btn-sm mx-1 btn-secondary">Secondary</button>
                <button type="button" class="btn btn-sm mx-1 btn-success">Success</button>
                <button type="button" class="btn btn-sm mx-1 btn-danger">删除</button>
                <button type="button" class="btn btn-sm mx-1 btn-warning">编辑</button>
                <button type="button" class="btn btn-sm mx-1 btn-info">Info</button>
                <button type="button" class="btn btn-sm mx-1 btn-dark">Dark</button> --}}
    </div>
    <div class="card-body px-3 py-2">
      <section class="markdown-body" style="background-color: transparent;">
        {!! markdown_to_html($post->description) !!}
      </section>
    </div>
    <div class="card-footer py-2 small d-flex align-items-center">
      <span class="px-2">{{ $post->updated_at }}</span>
      <span class="px-2 mr-auto">{{ Arr::get($post, 'user.name', $post['user_id']) }}</span>
      @if (Auth::check())
        {{-- <button type="button" class="btn btn-sm mx-1 btn-primary">Primary</button>
                <button type="button" class="btn btn-sm mx-1 btn-secondary">Secondary</button>
                <button type="button" class="btn btn-sm mx-1 btn-success">Success</button> --}}
        {{-- <a href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'update-content/' . ($post->id ?? $post->slug)) }}" role="button" class="btn btn-sm mx-1 btn-warning">编辑</a> --}}
        {{-- <button type="button" class="btn btn-sm mx-1 btn-info">Info</button>
                <button type="button" class="btn btn-sm mx-1 btn-dark">Dark</button> --}}
      @endif
      <a href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'content/' . ($post->id ?? $post->slug)) }}" class="alert alert-info py-1 mb-0 ml-1" role="alert">
        <small>阅读更多</small>
      </a>
    </div>
  </div>
@endforeach
