@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-4">
    <img src="{{$user->image ? $user->image->path : ''}}" class="img-thumbnail avatar">
  </div>
  <div class="col-md-8">
    <h3>{{$user->name}}</h3>
  </div>
  <p>Currently viewed by {{$counter}} other users!</p>
  @commentForm(['route'=> route('users.comments.store', ['user' => $user->id])])
  @endcommentForm

  @commentList(['comments' => $user->commentsOn])
  @endcommentList
</div>
@endsection
