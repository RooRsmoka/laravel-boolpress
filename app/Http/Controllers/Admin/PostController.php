<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Traits\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use SlugGenerator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::user()->id)->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:30',
            'category_id' => 'nullable',
            'tags' => 'nullable',
            'postImage' => 'nullable|image|max:500'
        ]);

        $post = new Post();
        $post->fill($data);
        $slug = $this->generateUniqueSlug($post->title);

        $post->slug = $slug;
        $post->user_id = Auth::user()->id;

        if (key_exists('postImage', $data)) {
            $post->postImage = Storage::put('postCovers', $data['postImage']);
        }

        $post->save();

        if (key_exists('tags', $data)) {
            $post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:30',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'postImage' => 'nullable|image|max:500'
        ]);

        $post = Post::findOrFail($id);

        if ($data['title'] !== $post->title) {

            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        $post->update($data);

        if (key_exists('postImage', $data)) {

            if ($post->postImage) {
                Storage::delete($post->postImage);
            }

            $postImage = Storage::put('postCovers', $data['postImage']);

            $post->postImage = $postImage;
            $post->save();
        }

        if (key_exists('tags', $data)) {
            $post->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->trashed()) {
            $post->tags()->detach();

            if ($post->postImage) {
                Storage::delete($post->postImage);
            }

            $post->forceDelete();
        } else {
            $post->delete();
        }

        return redirect()->route('admin.posts.index');
    }
}
