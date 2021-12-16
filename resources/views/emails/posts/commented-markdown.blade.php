@component('mail::message')
# New Comment on your blog post {{$comment->commentable->title}}

Hi {{$comment->commentable->user->name}}
@component('mail::button', ['url' => route('posts.show', [ "post" => $comment->commentable->id])])
  View the Blog Post
@endcomponent

@component('mail::button', ['url' => route('users.show', [ "user" => $comment->user->id])])
  Visit {{$comment->user->name}} profile
@endcomponent
@component("mail::panel")
{{$comment->content}}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
