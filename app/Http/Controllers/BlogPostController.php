<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
    $posts = BlogPost::mostComments()->get();
    return view('posts.index', [
      'posts' => $posts,
      'mostActiveLastMonth' => User::withMostBlogPostsLastMonth()->take(5)->get()
    ]);
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
    $post = BlogPost::with([
      'comments' => fn ($query) => $query->latest()
    ])->findOrFail($id);
    return view('posts.show', ['post' => $post]);
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
    return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(StorePost $request, $id)
  {
    $post = BlogPost::findOrFail($id);
    $this->authorize($post);
    $validated = $request->validated();
    $post->fill($validated)->save();
    $request->session()->flash('status', "Blog post Updated successfully");
    return redirect()->route('posts.show', ['post' => $post]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $post = BlogPost::findOrFail($id);
    $this->authorize($post);
    $post->delete();
    session()->flash('status', "Blog post Deleted successfully");
    return redirect()->route('posts.index');
  }
}
