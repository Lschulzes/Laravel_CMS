@extends('layouts.app')

@section('title', 'Update the post')

@section('content')
<form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
  @csrf
  @method('PUT')
  @include('posts.partials.form')
  @can ('update',$post)
  <div>
    <input type="submit" value="Update" class="btn btn-primary btn-block mt-2">
  </div>
  @endcan

</form>
<form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
  @csrf
  @method('DELETE')
  <div class="my-2">
    <input type="submit" value="DELETE" class="btn btn-danger btn-block">
  </div>
</form>
@endsection

