<div class="d-flex justify-content-between py-1">
  <h3><a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a></h3>
<div class="actions d-flex">
  <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-primary mr-2">EDIT</a>
  <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div>
      <input class="btn btn-danger" type="submit" value="DELETE" >
    </div>
  </form>
  @if ($post->comments_count)
  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comments({{$post->comments_count}})</p>
  @else
  <p>&nbsp;&nbsp;&nbsp;No Comments</p>

  @endif

</div>
</div>
