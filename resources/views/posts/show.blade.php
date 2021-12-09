@extends("layouts.app")
@section('title', $post->title)
@section('content')
<div class="row">
  <div class="col-lg-8">
@tags(['tags' => $post->tags])
@endtags
<h1>{{$post->title}}</h1>
<p>{{$post->content}}</p>
<p>Added {{$post->created_at->diffForHumans()}}</p>
@if(now()->diffInMinutes($post->created_at) < 5)
<div class="alert alert-success" role="alert">
  <span class="alert-heading">New!</span>
</div>
@endif
<p>Currently being read by {{$counter}} people</p>
@can ('update',$post)
<div class="d-flex gap-2">
  <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-primary mr-2 w-50">EDIT</a>
  @endcan
  @can ('delete',$post)
  <form class=" w-50" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div>
      <input class="btn btn-danger  w-100" type="submit" value="{{$post->trashed()? 'FORCE ':''}} DELETE" >
    </div>
  </form>
  @endcan
@can ('update',$post)
</div>
@endcan
@if ($post->comments)
<h3>Comments ({{count($post->comments)}})</h3>
@foreach ($post->comments as $comment)
<div style="background: #eee; padding: 0.5rem 1rem 0.25rem 1rem; border-radius: 8px; margin-bottom: 1rem">
<p>{{$comment->content}}</p>
<p>{{$comment->created_at->diffForHumans()}}</p>
</div>
@endforeach
@endif
</div>
<div class="col-lg-4 text-center d-lg-block d-none">
  @include('posts.partials._activity')
</div>
</div>
@endsection
