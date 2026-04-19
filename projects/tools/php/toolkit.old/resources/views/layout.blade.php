<!DOCTYPE html>
<html lang="en">

<head>
  <title>Toolkit</title>
  @include('shared.head')
</head>

<body>
  @section('header')
    @include('shared.header')
  @show
  <main>
    <div class="container">
      @section('content')

      @show
      @isset($links)
        @include('shared.links')
      @endisset
      @isset($refs)
        @include('shared.refs')
      @endisset
  </main>
  @section('footer')
    @include('shared.footer')
  @show
</body>

</html>
