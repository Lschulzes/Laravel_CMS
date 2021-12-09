@extends('layouts.app')

@section('title', 'Create the post')

@section('content')
<form action="{{ route('posts.store') }}" method="POST">
  @csrf
  @include('posts.partials._form')
  <div class="my-2">
    <input type="submit" value="Create" class="btn btn-primary btn-block">
  </div>

</form>
@endsection
