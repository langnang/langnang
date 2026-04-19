@extends($_module['slug'] . '::layouts.' . $_module['layout'])

@section('content')
  @if (View::exists($moduleConfig['slug'] . '::' . $_module['slug'] . '.index'))
    @include($moduleConfig['slug'] . '::' . $_module['slug'] . '.index')
  @endif
@endsection
