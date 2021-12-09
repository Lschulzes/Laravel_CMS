@if (isset($tags) && is_countable($tags))
<p class="d-flex gap-3">
  @foreach ($tags as $tag)
    <a href="{{route('posts.tags.index', ['id' => $tag->id])}}" class="badge badge-lg bg-success p-2 text-decoration-none light-link">
      {{$tag->name}}
    </a>
  @endforeach
</p>
@endif
