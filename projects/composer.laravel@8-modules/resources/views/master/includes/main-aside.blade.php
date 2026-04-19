<form class="my-2" action="{{ url($_module['alias'] . '/') }}" method="GET">
  <div class="form-group mb-2">
    <div class="input-group input-group-sm mb-0">
      <input type="text" class="form-control form-control-sm" name="title" placeholder="Title" value="{{ request('title') }}">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </div>
</form>

@empty(Arr::get($_module, 'associated_modules'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      子类
    </div>
    <ul class="list-group list-group-flush" style="max-height: 197px;overflow: auto;">
      @foreach (Arr::get($_module, 'associated_modules', []) as $meta)
        <a class="list-group-item text-truncate py-1 pr-1" style="display: inline-table" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'meta/' . ($meta->id ?? $meta->slug)) }}" title="{{ $meta->name }}">{{ $meta->name }}</a>
      @endforeach
    </ul>
  </div>
@endempty


@empty(Arr::get($_module, 'associated_categories'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      分类
    </div>
    <ul class="list-group list-group-flush placeholder-glow" style="max-height: 197px;overflow: auto;" lazy-url="{{ url('section') }}?view={{ $alias }}({{ Arr::get($_module, 'meta.id') }})::master:meta_tree&{{ Arr::query(request()->all()) }}">
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: .9rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: .9rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.2rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: .9rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.2rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.5rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
      <li class="list-group-item py-1 pr-1 d-flex align-items-center" style="padding-left: 1.8rem;">
        <a class="text-truncate mr-auto w-100" href="#" title="">
          <span class="placeholder rounded-pill col-5"></span>
        </a>
      </li>
    </ul>
    {{-- <x-bootstrap4.tree-group class="list-group-flush" style="max-height: 197px;overflow: auto;" item-class="py-1 pr-1 d-flex align-items-center text-truncate" :data="$categories">

    </x-bootstrap4.tree-group> --}}
  </div>
@endempty


@empty(Arr::get($_module, 'associated_tags'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      标签
    </div>
    <div class="card-body py-2 pl-2 pr-1" style="max-height: 320px;overflow: auto;">
      @foreach (Arr::get($_module, 'associated_tags', []) as $tag)
        <a class="badge badge-pill badge-primary text-truncate my-1" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'meta/' . ($tag->id ?? $tag->slug)) }}" title="{{ $tag->name }}" style="max-width: 100%;">{{ $tag->name }}</a>
      @endforeach
    </div>
  </div>
@endempty


@empty(Arr::get($_module, 'associated_latest_comments'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最新
    </div>
    <ul class="list-group list-group-flush">
      @foreach (Arr::get($_module, 'associated_latest_comments', []) as $latest_content)
        <a class="list-group-item text-truncate py-1  pr-1" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'content/' . ($latest_content->id ?? $latest_content->slug)) }}" title="{{ $latest_content->title }}">{{ $latest_content->title }}</a>
      @endforeach
    </ul>
  </div>
@endempty



@empty(Arr::get($_module, 'associated_hottest_contents'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最热
    </div>
    <ul class="list-group list-group-flush">
      @foreach (Arr::get($_module, 'associated_hottest_contents', []) as $hottest_content)
        <a class="list-group-item text-truncate py-1 pr-1" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'content/' . ($hottest_content->id ?? $hottest_content->slug)) }}" title="{{ $hottest_content->title }}">{{ $hottest_content->title }}</a>
      @endforeach
    </ul>
  </div>
@endempty


@empty(Arr::get($_module, 'associated_latest_comments'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      最新回复
    </div>
    <ul class="list-group list-group-flush">
      @foreach (Arr::get($_module, 'associated_latest_comments', []) as $latest_comment)
        <a class="list-group-item text-truncate py-1 pr-1" href="{{ url((isset($_module) ? $_module['alias'] . '/' : 'home/') . 'content/' . $latest_comment->content_id) }}" title="{{ $latest_comment->text }}">{{ $latest_comment->text }}</a>
      @endforeach
    </ul>
  </div>
@endempty

@empty(Arr::get($_module, 'associated_links'))
@else
  <div class="card my-2">
    <div class="card-header p-2">
      关联链接
    </div>
    <ul class="list-group list-group-flush">
      @foreach (Arr::get($_module, 'associated_links', []) as $link)
        <a class="list-inline-item col mr-0 my-1 d-flex align-items-center" href="{{ $link->url ?? '#' }}" target="_blank">
          <img class="mr-1" src="{{ $link->ico }}" alt="" height="20px">
          <small class="text-truncate mr-auto">{{ $link->title }}</small>
        </a>
      @endforeach
    </ul>
  </div>
@endempty
