@if (isset($tags) && is_countable($tags))
<p class="d-flex gap-3">
  @foreach ($tags as $tag)
    <a href="#" class="badge badge-lg bg-success p-2 text-decoration-none light-link">
      {{$tag->name}}
    </a>
  @endforeach
</p>
@endif
