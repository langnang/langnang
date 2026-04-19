<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Button trigger modal -->
      <x-admin::master.modal-iframe src="{{ url('admin/ssential/metas') }}" />
      <div class="col-md-12">
        <form method="post" enctype="multipart/form-data" name="content-row">
          @csrf
          <input type="hidden" name="_action" value="{{ old('_action') }}">
          <div class="card card-outline card-primary">
            <a class="card-header py-2" data-toggle="collapse" href="#meta-row">
              <h3 class="card-title"> Row </h3>
            </a>
            <div class="collapse show" id="meta-row">

              <div class="card-body pt-3 pb-0">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Name</span>
                      </div>
                      <input type="text" class="form-control" name='name' placeholder="--Name--" value="{{ old('name', $item['name']) }}"required>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Slug</span>
                      </div>
                      <input type="text" class="form-control" name='slug' placeholder="--Slug--" value="{{ $item['slug'] ?? '' }}">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Module</span>
                      </div>
                      <select class="form-control" name='module'>
                        <option value="">--Module--</option>
                        @foreach (Module::all() ?? [] as $moduleName => $moduleObject)
                          <option value="{{ $moduleObject->getAlias() }}" @if ($moduleObject->getAlias() == old('module', $item['module'])) selected @endif>
                            {{ $moduleName }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Ico</span>
                      </div>
                      <input type="text" class="form-control" name='ico' placeholder="--Ico--" value="{{ $item['ico'] ?? '' }}">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Type</span>
                      </div>
                      <select class="form-control" name='type'>
                        <option value="">--Type--</option>
                        @foreach (Arr::get($_module, 'options.meta.type', []) as $option)
                          <option value="{{ $option['value'] }}" @if ($option['value'] == old('type', $item['type'])) selected @endif>
                            {{ $option['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                      </div>
                      <select class="form-control" name='status'>
                        <option value="">--Status--</option>
                        @foreach (Arr::get($_module, 'options.meta.status', []) as $option)
                          <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif>
                            {{ $option['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Order</span>
                      </div>
                      <input type="number" min="0" max="99" class="form-control" name='order' placeholder="--Order--" value="{{ $item['order'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Description</span>
                      </div>
                      <textarea name="description" class="form-control" rows="1">{{ $item['description'] ?? '' }}</textarea>
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Upload</span>
                      </div>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" accept=".json,.xlsx,.csv,.md,.txt" name="file">
                        <label class="custom-file-label">Choose file...</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer py-2">
                <div class="row">
                  <div class="col mr-auto">

                  </div>
                  <div class="col col-auto">
                    {{-- <button type="button" class="btn btn-sm btn-secondary" onclick="$('[name=_action]').val('draft');$('form[name=content-row]').submit()">Draft</button> --}}
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    {{-- <button type="button" class="btn btn-sm btn-warning" onclick="$('[name=_action]').val('release');$('form[name=content-row]').submit()">Release</button> --}}
                    <a type="button" class="btn btn-sm btn-warning" href="factory">Factory</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-12">
        <div class="card card-outline card-info">
          <a class="card-header py-2" data-toggle="collapse" href="#meta-family">
            <h3 class="card-title d-flex justify-content-between align-items-center w-100"> Family
              <span class="badge badge-warning badge-pill">{{ $item->children_count }}</span>
            </h3>
          </a>
          <div class="collapse show" id="meta-family">
            <ul class="list-group list-group-flush">
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/metas?iframe=1&parent=' . $item->id . '&type=module') }}">
                children?type=module
                <span class="badge badge-primary badge-pill">14</span>
              </a>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/metas?iframe=1&parent=' . $item->id . '&type=category') }}">
                children?type=category
                <span class="badge badge-primary badge-pill">2</span>
              </a>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/metas?iframe=1&parent=' . $item->id . '&type=tag') }}">
                children?type=tag
                <span class="badge badge-primary badge-pill">1</span>
              </a>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/metas?iframe=1&parent=' . $item->id . '&type=group') }}">
                children?type=group
                <span class="badge badge-primary badge-pill">1</span>
              </a>
            </ul>
            <div class="card-footer py-2">
              <div class="row">
                <div class="col mr-auto">
                  Family footer
                </div>
                <div class="col col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card card-outline card-info">
          <a class="card-header py-2" data-toggle="collapse" href="#meta-relationship">
            <h3 class="card-title d-flex justify-content-between align-items-center w-100"> Relationship
              <span class="badge badge-warning badge-pill">{{ $item->relationships_count }}</span>
            </h3>
          </a>
          <div class="collapse show" id="meta-relationship">
            <ul class="list-group list-group-flush">
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/contentss?iframe=1&relation_meta=' . $item->id) }}">
                Content
                <span class="badge badge-primary badge-pill">14</span>
              </a>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/files?iframe=1&relation_meta=' . $item->id) }}">
                File
                <span class="badge badge-primary badge-pill">2</span>
              </a>
              <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="#" data-target="{{ url('admin/ssential/links?iframe=1&relation_meta=' . $item->id) }}">
                File
                <span class="badge badge-primary badge-pill">2</span>
              </a>
            </ul>
            <div class="card-footer py-2">
              <div class="row">
                <div class="col mr-auto">
                  Relationship footer
                </div>
                <div class="col col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @if (false && isset($item['id']) && $item->type == 'module')
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Meta?type=module</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['modules'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Meta?type=branch</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['branches'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
        <div class="col-4">
          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Meta?type=category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['categories'] ?? [] as $item_child)
                  <div class="form-check" style="padding-left: 1rem;">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                  @foreach ($item_child['children'] ?? [] as $item_child_02)
                    <div class="form-check" style="padding-left: 1.5rem;">
                      <input class="form-check-input" type="checkbox" disabled>
                      <label class="form-check-label">{{ $item_child_02['name'] }}</label>
                    </div>
                    @foreach ($item_child_02['children'] ?? [] as $item_child_03)
                      <div class="form-check" style="padding-left: 2rem;">
                        <input class="form-check-input" type="checkbox" disabled>
                        <label class="form-check-label">{{ $item_child_03['name'] }}</label>
                      </div>
                    @endforeach
                  @endforeach
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>

          <div class="card card-outline card-info">
            <div class="card-header py-2">
              <h3 class="card-title">Meta?type=tag</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body pt-3 pb-0">
              <div class="form-group">
                @foreach ($item['tags'] ?? [] as $item_child)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" disabled>
                    <label class="form-check-label">{{ $item_child['name'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- /.card-body -->

          </div>
        </div>
      @endif

    </div>

  </div>
</section>

<section>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label for="">Type</label>
              <input type="text" class="form-control form-control-sm">
            </div>
            <div class="form-group">
              <label for="">Value</label>
              <textarea type="text" class="form-control form-control-sm"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


</section>


@push('scripts')
  <script src="{{ asset('/public/plugins/dropzone/5.9.3/min/dropzone.min.js') }}"></script>
  <script src="{{ asset('/public/plugins/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js') }}"></script>
  {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.umd.min.js"></script> --}}
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ckeditor5@41.4.2/dist/browser/index.min.css"> --}}
  <script>
    $(document).on('click', '[name="insert-field"]', function(e) {
      console.log(e, $(this))
    })
    $(document).on('click', '[name="delete-field"]', function(e) {
      console.log(e, $(this))
    })
    $('#exampleModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var field = button.parents('.form-row')
      var field_name = field.find('[name]').val();
      var field_type = field.find('[name]').val();
      var field_value = field.find('[name]').val();
      console.log(parent)
      //   var signature = button.data('signature') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      //   var modal = $(this)
      //   modal.find('.modal-title').text('php artisan ' + signature)
      //   modal.find('.modal-body input').val(signature)
      //   axios({
      //     url: "/api/artisan",
      //     method: "post",
      //     data: {
      //       signature,
      //     },
      //   }).then(res => {
      //     console.log(modal, res);
      //     modal.find('.modal-body').text(res)
      //   });
    })
  </script>
  <script>
    $('.collapse .list-group-item.list-group-item-action').on('click', function(e) {
      console.log(`[.collapse .list-group-item.list-group-item-action]::click`, event);
      const target = $(this).data('target');
      console.log(target);
      $('iframe').attr('src', target);
      $('#exampleModal').modal('show')
    })
    $('#exampleModal').on('show.bs.modal', function(event) {
      console.log(`#exampleModal::show.bs.modal`, event);
      // do something...
    })
  </script>
  <script>
    $(function() {
      bsCustomFileInput.init();
    })
  </script>
@endpush
