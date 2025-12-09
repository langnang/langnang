@foreach ($categories as $category)
  @if (count($category->sites) != 0)
    <div class="card" id="{{ $category->name }}" style="padding-top:56px;margin-bottom:-40px;">
      <div class="card-body">
        <h4 class="text-gray"><i class="linecons-tag" style="margin-right: 7px;"></i>{{ $category->name }}</h4>
        @foreach ($category->sites->chunk(4) as $sites)
          <div class="row">

            @foreach ($sites as $site)
            <div class="col-sm-3">
              <div class="xe-widget xe-conversations box2 label-info" onclick="window.open('{{$site->url}}', '_blank')"
                   data-toggle="tooltip" data-placement="bottom" name="" data-original-name="$site->url">
                <div class="xe-comment-entry">
                  <a class="xe-user-img">
                    <img data-original="/public/webstack/uploads/$site->thumb" class="img-circle lazy" width="40"/>
                  </a>
                  <div class="xe-comment">
                    <a href="#{{$category->name}}" class="xe-user-name overflowClip_1">
                      <strong>{{$site->name}}</strong>
                    </a>
                    <p class="overflowClip_2">{{$site->describe}}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  @endif
@endforeach
