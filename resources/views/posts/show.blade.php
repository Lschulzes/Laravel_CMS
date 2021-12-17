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
<p>{{trans_choice("messages.people.reading", ["count" =>$counter])}}</p>
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
@commentForm(['route'=> route('posts.comments.store', ['post' => $post->id])])
@endcommentForm
@commentList(['comments' => $post->comments])
@endcommentList
@endif
</div>
<div class="col-lg-4 text-center d-lg-block d-none">
  @include('posts.partials._activity')
</div>
</div>
@endsection
