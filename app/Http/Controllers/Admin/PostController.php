<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
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
            'content' => 'required|min:20',
            'category_id' => 'nullable',
            'tags' => 'nullable'
        ]);

        $post = new Post();
        $post->fill($data);
        $slug = Str::slug($post->title);
        $exists = Post::where('slug', $slug)->first();
        $counter = 1;

        while ($exists) {
            $newSlug = $slug . '-' . $counter;
            $counter++;

            $exists = Post::where('slug', $newSlug)->first();

            if (!$exists) {
                $slug = $newSlug;
            }
        }

        $post->slug = $slug;
        $post->user_id = Auth::user()->id;
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
            'content' => 'required|min:20',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ]);

        $post = Post::findOrFail($id);

        if ($data['title'] !== $post->title) {

            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        $post->update($data);

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
        $post = Post::findOrFail($id);

        $post->tags()->detach();

        $post->delete();

        return redirect()->route('admin.posts.index');
    }


    protected function generateUniqueSlug($postTitle) {
        // Genero lo slug partendo dal titolo
        $slug = Str::slug($postTitle);
    
        // controllo a db se esiste già un elemento con lo stesso slug
        $exists = Post::where("slug", $slug)->first();
        $counter = 1;
    
        // Fino a che $exists ha un valore diverso da null o false eseguo il while
        while ($exists) {
          // Genero un nuovo slug, prendendo quello precedente concatenato con il counter incrementato.
          $newSlug = $slug . "-" . $counter;
          $counter++;
    
          // controllo a db se esiste già un elemento con i nuovo slug appena generato
          $exists = Post::where("slug", $newSlug)->first();
    
          // Se non esiste, salvo il nuovo slug nella variabile $slub che viene usato per assegnare
          // il valore del nuovo post.
          if (!$exists) {
            $slug = $newSlug;
          }
        }
    
        return $slug;
      }
}
