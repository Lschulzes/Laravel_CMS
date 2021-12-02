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
  @include('posts.partials.user')
</div>
@endsection
