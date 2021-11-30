@extends('layouts.app')
@section('content')
<form action="{{route('register.store')}}" method="POST">
  @csrf
  <div class="form-group">
    <label for="name" class="form-label">Name</label>
    <input
    type="text"  name="name"  id="name" value="{{old('name')}}" required
    class="form-control {{session('name_error') ? 'is-invalid':''}}">
    @if (session("name_error"))
    <span class="text-danger">
      <strong>{{session("name_error")}}</strong>
    </span>
    @endif
  </div>
  <div class="form-group">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" value="{{old('email')}}" required class="form-control {{session('email_error') ? 'is-invalid':''}}">
    @if (session("email_error"))
      <span class="text-danger">
        <strong>{{ session("email_error") }}</strong>
      </span>
    @endif
  </div>
  <div class="form-group">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" required class="form-control {{session('password_error') ? 'is-invalid':''}}">
    @if (session("password_error"))
    <span class="text-danger">
      <strong>{{session("password_error")}}</strong>
    </span>
    @endif
  </div>
  <div class="form-group">
    <label for="password_confirmation" class="form-label">Retyped Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
  </div>

  <button type="submit" class="btn btn-primary btn-block my-3 w-100">Register!</button>
</form>
@endsection
