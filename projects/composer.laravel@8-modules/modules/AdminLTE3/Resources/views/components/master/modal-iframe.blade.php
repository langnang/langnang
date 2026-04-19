@props([
    'name' => null,
    'slug' => null,
    'title' => null,
    'src' => null,
])
<!-- Modal -->
<div class="modal fade" id="iframeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width: 90vw;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Iframe Modal <small class="text-muted"></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        @if ($src)
          <iframe id="modal-iframe" src="{{ $src }}" frameborder="0" style="border :0;width: 100%;height: 60vh;"></iframe>
        @endif
      </div>
    </div>
  </div>
</div>


@push('scripts')
  <script>
    $(function() {

      $('#iframeModal').on('show.bs.modal', function(event) {
        // do something...
        console.log(`#iframeModal ~ show.bs.modal`, event);

        const relatedTarget = $(event.relatedTarget);
        const href = relatedTarget.data('href');

        console.log({
          href
        });
        if (href) {
          $(this).find('.modal-title small').html(`// ${href}`);
          $(this).find('.modal-body').html(`<iframe src="${href}" frameborder="0" style="border :0;width: 100%;height: 60vh;"></iframe>`);
        }
      });
      $('#iframeModal').on('shown.bs.modal', function(event) {
        // do something...
        console.log(`#iframeModal ~ shown.bs.modal`, event);
      });
      $('#iframeModal').on('hide.bs.modal', function(event) {
        // do something...
        console.log(`#iframeModal ~ hide.bs.modal`, event);
      });
      $('#iframeModal').on('hidden.bs.modal', function(event) {
        // do something...
        console.log(`#iframeModal ~ hidden.bs.modal`, event);
      });
      $('#iframeModal').on('hidePrevented.bs.modal', function(event) {
        // do something...
        console.log(`#iframeModal ~ hidePrevented.bs.modal`, event);

      });
    });
  </script>
@endpush
