@php
  $branches = $categories;
@endphp
  <!DOCTYPE html>
<html lang="zh">

@include('webstack.shared.head')

<body class="page-body">
<!-- skin-white -->
<div class="page-container">
  @section('aside')
    @include('webstack.shared.aside')
  @show
  <div class="main-content">
    @include('webstack.shared.header')
    <main style="min-height: calc(100vh - 122px);">
      @section('main')
      @show
    </main>

    @include('webstack.shared.footer')
  </div>
</div>
@include('webstack.shared.foot')
</body>

</html>
