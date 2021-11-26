<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{ mix('js/app.js')}}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Laravel App - @yield('title')</title>
</head>
<body>
  <header>
    <nav class="d-flex flex-column flex-md-row align-items-center justify-content-between p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
      <h5 class="my-0 mr-md-auto font-weight-normal">Laravel App</h5>
      <div class="links my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="{{route('home.index')}}">Home</a>
        <a class="p-2 text-dark" href="{{route('home.contact')}}">Contact</a>
        <a class="p-2 text-dark" href="{{route('posts.index')}}">Blog Posts</a>
        <a class="p-2 text-dark" href="{{route('posts.create')}}">Add Blog Post</a>
      </div>
    </nav>
  </header>
  <div class="container">
    @if (session('status'))
    <div class="alert alert-success">
      {{session('status')}}
    </div>
    @endif
      @yield('content')
  </div>
</body>
</html>
