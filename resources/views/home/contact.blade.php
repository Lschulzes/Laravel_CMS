@extends('layouts.app')
@section('title','Contact')
@section('content')
  <h1>Contact Page</h1>
  @can('home.secret')
    <a href="{{route('secret')}}">Special Contact details</a>
  @endcan
@endsection
