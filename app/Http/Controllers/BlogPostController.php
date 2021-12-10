<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\LiveVisits;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except('index', 'show');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $allBlogPosts = Cache::tags(['blog-post'])
      ->remember(
        'blog-posts',
        Constants::DEFAULT_CACHE_TIME,
        fn () => BlogPost::mostCommentsWithRelations()->get()
      );
    return view('posts.index', ['posts' => $allBlogPosts]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('posts.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePost $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = $request->user()->id;
    $post = BlogPost::create($validated);

    if ($request->hasFile('thumbnail')) {
      $file = $request->file('thumbnail');
      $fileName = Storage::putFileAs('thumbnails', $file, $post->id . "." . $file->guessExtension());
      $path = Storage::url($fileName);
      $post->image()->save(Image::create(['path' => $path]));
    }

    $request->session()->flash('status', 'The Blog Post Was Created!');

    return redirect()->route('posts.show', ['post' => $post->id]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $post = Cache::tags(['blog-post'])->remember(
      "blog-post-{$id}",
      Config::get('constants.options.DEFAULT_CACHE_TIME'),
      fn () => BlogPost::with(['comments' => fn ($query) => $query->latest(), 'tags', 'user', 'comments.user'])->findOrFail($id)
    );

    $liveVisits = new LiveVisits("blog-post-{$id}-counter", "blog-post-{$id}-users");
    $counter = $liveVisits->getCount();

    return view('posts.show', [
      'post' => $post,
      'counter' => $counter,
    ]);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $this->authorize('update',  BlogPost::find($id));
    return view('posts.edit', ['post' => BlogPost::singleWithRelations()->findOrFail($id)]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(StorePost $request, BlogPost $post)
  {
    $this->authorize($post);
    if ($post->trashed()) {
      $post->restore();
      return redirect()->route('posts.index');
    }

    $validated = $request->validated();
    $post->fill($validated)->save();

    if ($request->hasFile('thumbnail')) {
      $file = $request->file('thumbnail');
      Image::where('blog_post_id', '=', $post->id)?->delete();
      $fileName = Storage::putFileAs('thumbnails', $file, $post->id . "." . $file->guessExtension());
      $path = Storage::url($fileName);
      $post->image()->save(Image::create(['path' => $path]));
    }

    $request->session()->flash('status', "Blog post Updated successfully");
    return redirect()->route('posts.show', ['post' => $post->id]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(BlogPost $post)
  {
    $this->authorize($post);
    if ($post->trashed()) {
      $post->forceDelete();
      return redirect()->route('posts.index');
    }
    $post->delete();
    session()->flash('status', "Blog post Deleted successfully");
    return redirect()->route('posts.index');
  }
}
