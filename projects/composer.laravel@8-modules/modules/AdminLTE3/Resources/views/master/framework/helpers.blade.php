@extends($_module['slug'] . '::layouts.' . $_module['layout'])


@section('content')
  @isset($declaredClasses)
    @foreach ($declaredClasses as $class)
      <a href="helpers">{{ $class }}</a>
    @endforeach
  @else
    @foreach ($classMethods as $method)
      <a href="helpers">{{ $method }}</a>
    @endforeach
  @endisset
@endsection
