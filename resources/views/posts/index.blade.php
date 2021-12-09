@extends("layouts.app")
@section('title', 'Blog Posts')
@section('content')
<div class="row">
  <div class="col-lg-8">
    @forelse($posts as $key => $post)
    @include('posts.partials.post')
    @empty
    <p>No blog posts yet!</p>
    @endforelse
  </div>
  <div class="rmy-5 col-lg-4 text-center d-lg-block d-none">
    @include('posts.partials._activity')
  </div>
</div>
@endsection
