<div>
  @auth
  <form action="{{route('posts.comments.store', ['post' => $post->id])}}" method="POST">
    @csrf
    <div class="form-group">
      <textarea
      class="form-control"
      id="content"
      type="text"
      name="content"
      value="{{old('content', optional($post ?? null)->content) }}">
      </textarea>
    </div>
    <div class="my-2">
      <input type="submit" value="Add Comment" class="btn btn-secondary btn-block">
    </div>
  </form>
@else
<a href="{{route('login.index')}}">Login</a> to post Comments
@endauth
</div>
