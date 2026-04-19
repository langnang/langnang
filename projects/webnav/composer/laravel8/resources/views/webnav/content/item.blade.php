@extends('_layout.auto')


@section('main')
  <form class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="form-group">
          <label>地址：</label>
          <div class="input-group">
            <input type="text" class="form-control" name="url">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" style="border: 1px solid #ccc;"
                onclick="handleSpiderContent()">
                <i class="fa-solid fa-spider"></i>
              </button>
            </span>
          </div><!-- /input-group -->
        </div>
        <div class="form-group">
          <label>标题：</label>
          <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group">
          <label>徽标：</label>
          <input type="text" class="form-control" name="icon">
        </div>
        <div class="form-group">
          <label>描述：</label>
          <input type="text" class="form-control" name="description">
        </div>
      </div>
      <div class="col-md-4">3</div>
      <div class="col-md-12">3</div>
    </div>
  </form>
@endsection
