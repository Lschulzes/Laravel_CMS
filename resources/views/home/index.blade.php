@extends('layouts.app')
@section('title','Home')
@section('content')
<h1>{{__("messages.welcome")}}</h1>
<h1>@lang("messages.welcome")</h1>
<h1>{{__("Welcome to laravel")}}</h1>
<p>Content of the main page</p>
<p>@lang("messages.example_with_value", ["name" => "John"])</p>
<p>{{trans_choice("messages.plural", 0)}}</p>
<p>{{trans_choice("messages.plural", 1)}}</p>
<p>{{trans_choice("messages.plural", 2)}}</p>
<p>{{trans_choice("messages.plural", 3)}}</p>
@endsection
