<div class="row mb-5">
  <div class="d-flex flex-column justify-content-between">
    <h3><a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a></h3>
    <span>@tags(['tags' => $post->tags])@endtags</span>
    <div class="comments">
      <p>
        Added by <a href="{{route('users.show', ['user' => $post->user->id])}}">{{$post->user->name}}</a>
      </p>
      @if ($post->comments_count)
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comments({{$post->comments_count}})</p>
    </div>
  </div>

      @else
      <p>&nbsp;&nbsp;&nbsp;No Comments</p>
    </div>
  </div>
  @endif
  @auth
  <div class="actions d-flex">
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
  @endauth

</div>
