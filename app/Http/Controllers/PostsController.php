<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = BlogPost::withCount([
      'comments',
      'comments as new_comments' => function ($query) {
        $query->where('created_at', '>=', '2021-11-28 18:46:13');
      }
    ])->get();
    return view('posts.index', ['posts' => $posts]);
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
    $post = BlogPost::findOrFail($id);
    return view('posts.show', ['post' => $post, 'comments' => $post?->comments ?? []]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
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
    $post->delete();
    session()->flash('status', "Blog post Deleted successfully");
    return redirect()->route('posts.index');
  }
}
