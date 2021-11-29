@extends("layouts.app")
@section('title', $post->title)
@section('content')
<h1>{{$post->title}}</h1>
<p>{{$post->content}}</p>
<p>Added {{$post->created_at->diffForHumans()}}</p>
@if(now()->diffForHumans($post->created_at) < 5)
  <div class="alert alert-info">New!</div>
@endif
@if ($comments)
<h3>Comments ({{count($comments)}})</h3>
@foreach ($comments as $comment)
<div style="background: #eee; padding: 0.5rem 1rem 0.25rem 1rem; border-radius: 8px; margin-bottom: 1rem">
<p>{{$comment->content}}</p>
<p>{{$comment->created_at->diffForHumans()}}</p>
</div>
@endforeach

@endif

@endsection
