@extends('layouts.app')

@section('content')
<form
action="{{route('users.update', ['user' => $user->id])}}"
method="POST"
class="form-horizontal"
enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="row">
  <div class="col-md-4">
    <img src="{{$user->image ? $user->image->path : ''}}" class="img-thumbnail avatar">
    <div class="card mt-4">
      <div class="card-body p-4">
        <h6>Upload a different photo</h6>
        <input type="file" name="avatar" id="avatar" class="form-control form-control-file">
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group mb-3 mt-5">
      <label for="name">Name: </label>
      <input value="{{$user->name}}" type="text" class="form-control" name="name" id="name">
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Save Changes">
    </div>
  </div>
</div>
</form>
@endsection
