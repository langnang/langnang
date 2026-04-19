@extends($layout)

@section('content')
  <div class="container">
    {{-- @empty(($associated_modules = Arr::get($_module, 'associated_modules')))
    @else
      @foreach ($associated_modules as $associated_module)
        <div class="card my-2">
          <div class="card-header py-1">
            {{ $associated_module->name }}
          </div>
          <div class="card-body py-2">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>
          </div>
        </div>
      @endforeach
    @endempty --}}
    <div class="card my-2">
      <div class="card-header py-1">
        加密·Encrypt
      </div>
      <div class="card-body row row-cols-4 py-0">
        <div class="col py-1"> Base64 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
        <div class="col py-1"> MD5 </div>
      </div>
    </div>

    <div class="card my-2">
      <div class="card-header py-1">
        解谜·Decrypt
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
    <div class="card my-2">
      <div class="card-header py-1">
        生成·Generate
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
    <div class="card my-2">
      <div class="card-header py-1">
        转换·Transform
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
    <div class="card my-2">
      <div class="card-header py-1">
        爬虫·Spider
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
    <div class="card my-2">
      <div class="card-header py-1">
        搜寻·Hunt
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
    <div class="card my-2">
      <div class="card-header py-1">
        收录·Embody
      </div>
      <div class="card-body py-2">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
          content.
        </p>
      </div>
    </div>
  </div>
@endsection
