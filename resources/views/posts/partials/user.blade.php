<div class="rmy-5 col-lg-4 text-center d-lg-block d-none">
  <div class="card" style="width: 100%;">
    <div class="card-body">
      <h5 class="card-title">Most Active Users</h5>
      <p class="card-text">By monthly post count</p>
    </div>
    <ul class="list-group list-group-flush">
    @foreach ($mostActiveLastMonth as  $user)
    <a href="{{route('posts.show', $user->blogPosts->first())}}" class=" text-decoration-none" >
      <li class="list-group-item text-primary">{{$user->name}} Posts({{$user->blog_posts_count}})</li>
    </a>
    @endforeach
    </ul>
  </div>
</div>
