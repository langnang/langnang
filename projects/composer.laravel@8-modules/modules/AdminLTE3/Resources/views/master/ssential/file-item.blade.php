@extends('admin::layouts.master')


@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">
          <form method="post" enctype="multipart/form-data" name="content-row">
            @csrf
            <input type="hidden" name="_action" value="{{ old('_action') }}">
            <div class="card card-outline card-primary">
              <div class="card-header py-2">
                <h3 class="card-title">File Row</h3>
              </div>
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
                        @foreach (Arr::get($_module, 'options.file.type', []) as $option)
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
                        @foreach (Arr::get($_module, 'options.file.status', []) as $option)
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
          </form>
        </div>
      </div>

      @switch($item['type'])
        @case('txt')
          <div class="row">
            <div class="col-md-12">
              <x-bootstrap4.card-summernote :slug="$item->slug" :value="$item->content" />
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->
        @break

        @case('json')
          <div class="row">
            <div class="col-md-12">
              <x-bootstrap4.card-jsoneditor :slug="$item->slug" :value="$item->content" />
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->
        @break

        @case('md')
          <div class="row">
            <div class="col-md-12">
              <x-bootstrap4.card-simplemde :slug="$item->slug" :value="$item->content" />
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->
        @break

        @case('xls')
        @case('xlsx')

        @case('csv')
          <div class="row">
            <div class="col-md-12">
              <x-bootstrap4.card-luckysheet :slug="$item->slug" :value="$item->content" />
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->
        @break

        @default
          <div class="row">
            <div class="col-md-12">
              <x-bootstrap4.card-codemirror :slug="$item->slug" :value="$item->content" />
            </div>
          </div>
        @break
      @endswitch

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
    <script src="{{ asset('/public') }}/plugins/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script src="{{ asset('/public') }}/plugins/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('/public') }}/plugins/summernote/0.8.20/summernote-bs4.min.js"></script>
    <!-- CodeMirror -->

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> --}}

    <script src="https://unpkg.com/mr-excel@7.0.1/dist/excel-table.umd.cjs"></script>
    <script>
      const data = {
        creator: "mr",
        created: "2023-08-06T07:22:40Z",
        modified: "2023-08-06T07:22:40Z",
        styles: {
          formulaStyle: {
            backgroundColor: "B83B5E",
            border: {
              full: {
                style: "medium",
                color: "F9ED69",
              },
            },
          },
        },
        sheet: [{
            name: "Test",
            formula: {
              B16: {
                type: "SUM",
                start: "B2",
                end: "B8",
                styleId: "formulaStyle",
              },
            },
            tabColor: "B83B5E",
            headers: [{
                label: "test",
                text: "Test",
              },
              {
                label: "_id",
                text: "ID",
                formula: {
                  type: "MAX",
                  styleId: "formulaStyle",
                },
              },
            ],
            data: [{
                _id: 0.3,
                test: "test1",
              },
              {
                _id: 2,
                test: "test2",
              },
              {
                _id: 3,
                test: "test3",
              },
              {
                _id: 4,
                test: "test4",
              },
              {
                _id: 5,
                test: "test5",
              },
              {
                _id: 6,
                test: "test6",
              },
              {
                _id: 7,
                test: "test7",
              },
              {
                _id: 8,
                test: "test8",
              },
              {
                _id: 9,
                test: "test9",
              },
              {
                _id: 10,
                test: "test10",
              },
              {
                _id: 11,
                test: "test11",
              },
            ],
          },
          {
            headers: [{
                label: "test",
                text: "Test",
              },
              {
                label: "_id",
                text: "ID",
              },
            ],
            data: [{
                _id: 1,
                test: "test1",
              },
              {
                _id: 2,
                test: "test2",
              },
              {
                _id: 3,
                test: "test3",
              },
              {
                _id: 4,
                test: "test4",
              },
              {
                _id: 5,
                test: "test5",
              },
              {
                _id: 6,
                test: "test6",
              },
              {
                _id: 7,
                test: "test7",
              },
              {
                _id: 8,
                test: "test8",
              },
              {
                _id: 9,
                test: "test9",
              },
              {
                _id: 10,
                test: "test10",
              },
              {
                _id: 11,
                test: "test11",
              },
            ],
          },
        ],
      };
      //   ExcelTable.generateExcel(data);
      const rowF = (value, index, from) => {
        return 50
      }
      const colF = (value, index) => {
        return value * 0.19
      }
      //   ExcelTable.convertTableToExcel("#table", null, {
      //     keepStyle: true,
      //     rowHeightScaleFunction: rowF,
      //     colWidthScaleFunction: colF
      //   })
    </script>
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
    <script></script>
  @endpush
@endsection


@push('styles')
  <!-- SimpleMDE -->
  <style>
    .note-editor {
      margin-bottom: 0;
    }
  </style>
@endpush
