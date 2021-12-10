@extends("layouts.app")
@section('title', $post->title)
@section('content')
<div class="row">
  <div class="col-lg-8">
@tags(['tags' => $post->tags])
@endtags
@if ($post?->image)
<div style="background-image: url('{{$post->image->path}}'); min-height: 500px; color: white; text-align:center; background-repeat: no-repeat; background-size: cover; background-attachment: fixed; box-shadow:inset 0 0 0 2000px rgba(0, 0, 0, 0.75); background-position: center">
  <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
    {{$post->title}}
  </h1>
  <p>{{$post->content}}</p>
  @if(now()->diffInMinutes($post->created_at) < 5)
    <span class="badge bg-success">New!</span>
  @endif
</div>
@else
<h1>{{$post->title}}</h1>
<p>{{$post->content}}</p>
@endif
<p>Added {{$post->created_at->diffForHumans()}}</p>

<p>Created by {{$post->user->name}}</p>
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
@include('comments._form')
@foreach ($post->comments as $comment)
<div style="background: #eee; padding: 0.5rem 1rem 0.25rem 1rem; border-radius: 8px; margin-bottom: 1rem">
<p>{{$comment->content}}</p>
<p>{{$comment->created_at->diffForHumans()}}</p>
<p>Posted by {{$comment->user->name}}</p>
</div>
@endforeach
@endif
</div>
<div class="col-lg-4 text-center d-lg-block d-none">
  @include('posts.partials._activity')
</div>
</div>
@endsection
