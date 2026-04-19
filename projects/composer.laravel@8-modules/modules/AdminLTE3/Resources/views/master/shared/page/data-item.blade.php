<div class="card mb-2">
  <div class="card-header d-flex align-items-center py-2">
    <h3 class="card-title mr-auto">
      {{ Str::plural($name) }} DataItem
      <small class="text-muted d-none"><em>paging {{ Str::studly($slug) }} item data</em></small>
    </h3>
    @include('admin::master.shared.datatable-head-form')
  </div>
  <!-- /.card-header -->
  <form id="data-item" name="data-item" class="card-body mb-0 p-2" method="post" action="" style="height: calc(100vh - 275px);overflow-y: auto;">
    @csrf
    @include('admin::master.shared.form.' . $slug, ['full' => true])
  </form>
  <!-- /.card-body -->
  <div class="card-footer py-2 clearfix d-flex align-items-center">
    @include('admin::master.shared.datatable-foot-form')
  </div>
  <!-- /.card-footer -->
</div>

@once
  @push('scripts')
    <script>
      $(function() {
        $(document).on('click', '#head-submit, #foot-submit', function($e) {
          $('form#data-item').submit();
        });
        $(document).on('click', '#head-confirm, #foot-confirm', function($e) {
          $('form#data-item').attr('action', "{{ url('/admin/ssential/files/store') }}");
          $('form#data-item').submit();
          // $('form#data-item').submit();
        });
      })
    </script>
  @endpush
@endonce
