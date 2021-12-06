<div class="row ">
  <div class="d-flex justify-content-between py-1">
    <h3><a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a></h3>
  @guest
    @if ($post->comments_count)
    <p>Comments({{$post->comments_count}})</p>
    @else
    <p>No Comments</p>

    @endif
  @else
  <div class="actions d-flex">
    <p>
      Added by {{$post->user->name}}
    </p>
    @if ($post->comments_count)
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comments({{$post->comments_count}})</p>
    @else
    <p>&nbsp;&nbsp;&nbsp;No Comments</p>

    @endif

    @can ('update',$post)
    <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-primary mr-2">EDIT</a>
    @endcan
    @can ('delete',$post)
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
      @csrf
      @method('DELETE')
      <div>
        <input class="btn btn-danger" type="submit" value="{{$post->trashed()? 'FORCE ':''}} DELETE" >
      </div>
    </form>
    @endcan
    @if ($post->trashed())

    @can ('update',$post)
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
      @csrf
      @method('PUT')
      <input  id="title" type="hidden" name="title" value="{{old('title', optional($post ?? null)->title) }}">
      <input  id="title" type="hidden" name="content" value="{{old('content', optional($post ?? null)->content) }}">
      <div>
        <input class="btn btn-success" type="submit" value="RESTORE" >
      </div>
    </form>
    @endcan
    @endif
  </div>
  @endguest
  </div>

</div>
