<section class="content">
  <div class="row">
    <div class="col-12">

      <x-bootstrap4.card :header='false' :footer='false'>
        <div class="mailbox-controls">
          <!-- Check all button -->
          <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
          </button>
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm">
              <i class="far fa-trash-alt"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm">
              <i class="fas fa-reply"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm">
              <i class="fas fa-share"></i>
            </button>
          </div>
          <!-- /.btn-group -->
          <button type="button" class="btn btn-default btn-sm">
            <i class="fas fa-sync-alt"></i>
          </button>
          <!-- /.float-right -->
        </div>
      </x-bootstrap4.card>
    </div>
    <div class="col-12">
      @foreach ($list ?? [] as $index => $item)
        <x-bootstrap4.card title="Content Row" description="#{{ $item->id ?? $index + 1 }}" :collapseShow='false'>
          <form class="mb-0" method="post" action="">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Title</span>
                  </div>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $item['title']) }}">
                  @error('title')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Slug</span>
                  </div>
                  <input type="text" class="form-control" name='slug' value="{{ $item['slug'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Module</span>
                  </div>
                  <select class="form-control" name='module'>
                    <option value="">--Module--</option>
                    <option value="home" @if ($_module['alias'] == 'home') selected @endif>Home</option>
                    @foreach (Module::allEnabled() ?? [] as $_moduleName => $_moduleObject)
                      <option value="{{ $_moduleObject->getAlias() }}" @if ($_moduleObject->getAlias() == old('module', $_module['alias'])) selected @endif>
                        {{ $_moduleName }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Ico</span>
                  </div>
                  <input type="text" class="form-control" name='ico' value="{{ $item['ico'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-md-3">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Type</span>
                  </div>
                  <select class="form-control" name='type'>
                    @foreach (Arr::get($_module, 'options.content.type', []) as $option)
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
                    @foreach (Arr::get($_module, 'options.content.status', []) as $option)
                      <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif>
                        {{ $option['name'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Description</span>
                  </div>
                  <textarea name="description" id="" class="form-control" rows="2">{{ $item['description'] ?? '' }}</textarea>
                </div>
              </div>
              <div class="form-group col-12 d-none">
                <textarea id="" name="text" class="form-control form-control-sm" rows="3">{!! $item['text'] ?? '' !!}</textarea>
              </div>
              <div class="form-group col-12 mb-0" style="height: calc(100vh - 459px);overflow-y: auto;">
                <div class="input-group input-group-sm">
                  <textarea name="text" id="codeMirror" class="form-control" rows="2" style="font-size: 1rem;height: 300px;">{{ $item['text'] ?? '' }}</textarea>
                </div>
              </div>
            </div>
          </form>
          <x-slot name="slotFooter">
            <div class="row">
              <div class="col mr-auto">
                <button type="button" data-role="submit" class="btn btn-sm btn-primary">Submit</button>
                <button type="button" data-role="release" class="btn btn-sm btn-warning">Release</button>
              </div>
              <div class="col col-auto">
                <button type="button" data-role="draft" class="btn btn-sm btn-secondary">Draft</button>
              </div>
            </div>
          </x-slot>
        </x-bootstrap4.card>
      @endforeach
      <div class="card card-outline card-primary d-none">
        <div class="card-header d-flex align-items-center py-2">
          <h3 class="card-title mr-auto">Content Row</h3>
          <form class="form-inline mb-0" name="table">
            <div class="form-group ml-1">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name='spider' value="{{ $item['spider'] ?? request()->input('spider') }}">
                <div class="input-group-append">
                  <button class="btn btn-info" type="submit"><i class="fas fa-spider"></i></button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <form method="post" name="content" class="card-body pb-0">
          <div class="form-row">
            <div class="form-group col-md-6">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Title</span>
                </div>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $item['title']) }}">
                @error('title')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="form-group col-md-3">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Slug</span>
                </div>
                <input type="text" class="form-control" name='slug' value="{{ $item['slug'] ?? '' }}">
              </div>
            </div>
            <div class="form-group col-md-3">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Module</span>
                </div>
                <select class="form-control" name='module' disabled>
                  <option value="">--Module--</option>
                  <option value="home" @if ($_module['alias'] == 'home') selected @endif>Home</option>
                  @foreach (Module::all() ?? [] as $_moduleName => $_moduleObject)
                    <option value="{{ $_moduleObject->getAlias() }}" @if ($_moduleObject->getAlias() == old('module', $_module['alias'])) selected @endif>
                      {{ $_moduleName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Ico</span>
                </div>
                <input type="text" class="form-control" name='ico' value="{{ $item['ico'] ?? '' }}">
              </div>
            </div>
            <div class="form-group col-md-3">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Type</span>
                </div>
                <select class="form-control" name='type'>
                  @foreach (Arr::get($_module, 'options.content.type', []) as $option)
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
                  @foreach (Arr::get($_module, 'options.content.status', []) as $option)
                    <option value="{{ $option['value'] }}" @if ($option['value'] == old('status', $item['status'])) selected @endif>
                      {{ $option['name'] }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group col-12">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Description</span>
                </div>
                <textarea name="description" id="" class="form-control" rows="2">{{ $item['description'] ?? '' }}</textarea>
              </div>
            </div>
            <div class="form-group col-12 d-none">
              <textarea id="" name="text" class="form-control form-control-sm" rows="3">{!! $item['text'] ?? '' !!}</textarea>
            </div>
            <div class="form-group col-12 ">
              <div class="input-group input-group-sm">
                <textarea name="text" id="codeMirror" class="form-control" rows="2" style="font-size: 1rem;height: 300px;">{{ $item['text'] ?? '' }}</textarea>
              </div>
            </div>
          </div>
          @csrf
        </form>
        <div class="card-footer py-2">
          <div class="row">
            <div class="col mr-auto">
              <button type="button" data-role="submit" class="btn btn-sm btn-primary">Submit</button>
              <button type="button" data-role="release" class="btn btn-sm btn-warning">Release</button>
            </div>
            <div class="col col-auto">
              <button type="button" data-role="draft" class="btn btn-sm btn-secondary">Draft</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if (false)
      <div class="col-12">
        <x-bootstrap4.card title="Content Relation Categories">
          <x-slot name="slotFooter">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </x-slot>
        </x-bootstrap4.card>
        <x-bootstrap4.card title="Content Relation Tags">
          <x-slot name="slotFooter">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </x-slot>
        </x-bootstrap4.card>
        <x-bootstrap4.card title="Content Relation Links">
          <x-slot name="slotFooter">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </x-slot>
        </x-bootstrap4.card>
        <x-bootstrap4.card title="Content Relation Files">
          <x-slot name="slotFooter">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </x-slot>
        </x-bootstrap4.card>
      </div>
    @endif
  </div>

  <div class="d-none">
    <div id="editor">
      {{ $item['text'] ?? '' }}
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


</section>

@push('scripts')
  <script src="{{ asset('/public/plugins/codemirror/codemirror.js') }}"></script>
  <script src="{{ asset('/public/plugins/codemirror/mode/css/css.js') }}"></script>
  <script src="{{ asset('/public/plugins/codemirror/mode/xml/xml.js') }}"></script>
  <script src="{{ asset('/public/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
  <script src="{{ asset('/public/plugins/codemirror/mode/markdown/markdown.js') }}"></script>
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
    $(function() {
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      const codeMirrorEditor = CodeMirror.fromTextArea(document.getElementById("codeMirror"), {
        mode: "markdown",
        lineNumbers: true, // 显示行数
        indentUnit: 4, // 缩进单位为4
        styleActiveLine: true, // 当前行背景高亮
        matchBrackets: true, // 括号匹配
        lineWrapping: true, // 自动换行
        theme: 'monokai', // 使用monokai模板
      });
      codeMirrorEditor.setSize('auto', '500px');
      $(document).on('click', '[data-role="submit"]', function($e) {
        console.log($e);
        $('[name="text"]').val(codeMirrorEditor.getValue());
        console.log($('[name="text"]').val());
        $('form[name=content]').submit();
      });
      $(document).on('click', '[data-role="release"]', function($e) {
        console.log($e);
      });
      $(document).on('click', '[data-role="draft"]', function($e) {
        console.log($e);
      });
    })



    // $(document).ready(() => {
    //   ckeditor5.ClassicEditor
    //     .create(document.querySelector('#editor'), {
    //       toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    //       heading: {
    //         options: [{
    //             model: 'paragraph',
    //             title: 'Paragraph',
    //             class: 'ck-heading_paragraph'
    //           },
    //           {
    //             model: 'heading1',
    //             view: 'h1',
    //             title: 'Heading 1',
    //             class: 'ck-heading_heading1'
    //           },
    //           {
    //             model: 'heading2',
    //             view: 'h2',
    //             title: 'Heading 2',
    //             class: 'ck-heading_heading2'
    //           }
    //         ]
    //       }
    //     })
    //     .catch(error => {
    //       console.error(error);
    //     });
    // })
  </script>
@endpush

@push('styles')
  <style>
    .CodeMirror-wrap {
      width: 100% !important;
      /* height: calc(100vh - 459px); */
      /* overflow-y: auto; */
    }

    .CodeMirror-code {
      min-height: calc(100vh - 466px);
      /* overflow-y: auto; */
    }
  </style>
@endpush
