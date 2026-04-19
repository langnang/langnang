@extends('admin::layouts.master')


@section('content')
  <section class="content">
    @empty($meta_id)
      <x-bootstrap4.card title="Relation Metas">
        @foreach ($meta_modules ?? [] as $module)
          <x-bootstrap4.card title="Module {{ $module->name }}" selection>
            <x-bootstrap4.card title="Categories {{ $module->name }}" selection>
              <x-admin::master.expandable-table :children="$module->children ?? []" />
            </x-bootstrap4.card>
            <x-bootstrap4.card title="Tags {{ $module->name }}" selection>
            </x-bootstrap4.card>
          </x-bootstrap4.card>
        @endforeach
      </x-bootstrap4.card>
    @endempty
    @empty($content_id)
      <x-bootstrap4.card title="Relation Contents">

      </x-bootstrap4.card>
    @endempty
    @empty($link_id)
      <x-bootstrap4.card title="Relation Links">
        @slot('slotHeadRight')
          <form class="form form-inline" action="">

            <div class="form-group flex-shrink-1" data-select2-id="42">
              <label>Multiple</label>
              <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                <option data-select2-id="43">Alabama</option>
                <option data-select2-id="44">Alaska</option>
                <option data-select2-id="45">California</option>
                <option data-select2-id="46">Delaware</option>
                <option data-select2-id="47">Tennessee</option>
                <option data-select2-id="48">Texas</option>
                <option data-select2-id="49">Washington</option>
              </select>
              <span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="8" style="width: 100%;">
                <span class="selection">
                  <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                    <ul class="select2-selection__rendered">
                      <li class="select2-selection__choice" title="Alaska" data-select2-id="59"><span class="select2-selection__choice__remove" role="presentation">×</span>Alaska</li>
                      <li class="select2-selection__choice" title="California" data-select2-id="60"><span class="select2-selection__choice__remove" role="presentation">×</span>California</li>
                      <li class="select2-selection__choice" title="Delaware" data-select2-id="61"><span class="select2-selection__choice__remove" role="presentation">×</span>Delaware</li>
                      <li class="select2-selection__choice" title="Tennessee" data-select2-id="62"><span class="select2-selection__choice__remove" role="presentation">×</span>Tennessee</li>
                      <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                    </ul>
                  </span>
                </span>
                <span class="dropdown-wrapper" aria-hidden="true"></span>
              </span>
            </div>
          </form>
        @endslot
      </x-bootstrap4.card>
    @endempty
    @empty($file_id)
      <x-bootstrap4.card title="Relation Files"></x-bootstrap4.card>
    @endempty
  </section>
@endsection

@push('scripts')
  {{-- <x-script path="" src="" /> --}}
  <x-script slug="select2:4.0.13" />
  <script>
    $(document).ready(function() {
      // $('.js-example-basic-multiple').select2();
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
  </script>
@endpush

@push('styles')
  <x-style slug="select2:4.0.13" />
  <x-style slug="select2-bootstrap4-theme" />
@endpush
