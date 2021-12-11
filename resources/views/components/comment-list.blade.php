@forelse ($comments as $comment)
<div style="background: #eee; padding: 0.5rem 1rem 0.25rem 1rem; border-radius: 8px; margin-bottom: 1rem">
@tags(['tags' => $comment->tags])@endtags
<p>{{$comment->content}}</p>
<p>{{$comment->created_at->diffForHumans()}}</p>
<p>Posted by {{$comment->user->name}}</p>
</div>
@empty
<p>No comments yet!</p>
@endforelse
