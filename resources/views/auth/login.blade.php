@extends('layouts.app')
@section('content')
<h3 class="text-center">Login</h3>
<form action="{{route('login.store')}}" method="POST">
  @csrf
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
    <div class="form-check d-flex justify-content-center gap-2 mt-2">
      <input id="remember" type="checkbox" class="form-check-input" name="remember" value="{{old("remember") ? 'checked':''}}">
      <label for="remember" class="form-check-label">Remember Me</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary btn-block my-3 w-100">Login!</button>
</form>
@endsection
