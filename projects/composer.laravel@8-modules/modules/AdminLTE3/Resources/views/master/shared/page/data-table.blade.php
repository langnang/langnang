<div class="card mb-2">
  <div class="card-header d-flex align-items-center py-2">
    <h3 class="card-title mr-auto">
      {{ Str::plural($name) }} DataTable
      <small class="text-muted d-none"><em>paging {{ Str::plural($slug) }} paginator data</em></small>
    </h3>
    @include('admin::master.shared.datatable-head-form')
  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0" style="height: calc(100vh - 275px);">
    @include('admin::master.shared.datatable-body', [])
  </div>
  <!-- /.card-body -->
  <div class="card-footer py-1 clearfix d-flex align-items-center">
    @include('admin::master.shared.datatable-foot-form')
  </div>
  <!-- /.card-footer -->
</div>



@push('scripts')
  <script>
    $(function() {
      $('.checkbox-toggle').click(function() {
        var clicks = $(this).data('clicks')
        if (clicks) {
          //Uncheck all checkboxes
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          //Check all checkboxes
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $('.card-body input[type=\'checkbox\']').prop('checked', !clicks)
        $(this).data('clicks', !clicks)
        $(this).next().data('clicks', !clicks)
        $(this).next().text(clicks ? '全选' : '全不选')
      });
      $('.checkbox-toggle+.btn').click(function() {
        var clicks = $(this).data('clicks')
        //Check all checkboxes
        if (clicks) {
          $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
        } else {
          $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
        }
        $('.card-body input[type=\'checkbox\']').prop('checked', !clicks)
        $('.checkbox-toggle').data('clicks', !clicks)
        $('.checkbox-toggle').prop('checked', !clicks)
        $(this).data('clicks', !clicks)
        $(this).text(clicks ? '全选' : '全不选')
      });
      $(document).on('change', 'input[type=file]', function(e) {
        console.log(e, $(this))
      });
      $(document).on('change', '#foot-multiple select[name="operation"]', function(e) {
        console.log(e)
        console.log($(this).val())
        const val = $(this).val();
        const ids = [...$(".card-body input[type='checkbox']:checked")].reduce((t, v) => [...t, $(v).val()], []);
        let action = "{{ url('admin/ssential/' . Str::plural($slug)) }}/";
        if (['delete', ].includes(val)) {
          action += val + "/";
        }
        $("form#foot-multiple").attr('action', action + ids.join(",")).submit();
        // var selectedValues = [];
        // console.log($(".card-body input[type=\'checkbox\']:checked"));

        // $("form#foot-multiple").attr('action', '{{ Str::plural($slug) }}/' + ids.join(",")).submit();
        // console.log(ids);
        // $('input[name=\'ids\']').val(ids.join(","));
        // var selectedValueStr = selectedValues.join(", ");
        // console.log("选中的值是: " + selectedValueStr);
        // console.log($('.card-body input[type=\'checkbox\']').val())

        // $("form[name='batch-operation']").submit();
      });
    })
  </script>
@endpush
