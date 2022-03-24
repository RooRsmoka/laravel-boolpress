<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Traits\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use SlugGenerator;

    public function index(Request $request) {
        $filter = $request->input('filter');
        // $posts = Post::paginate(3);

        if ($filter) {
            $posts = Post::where('title', 'LIKE', '%$filter%')->paginate(3);
        } else {
            $posts = Post::paginate(6);
        }

        $posts->load('user', 'category', 'tags');

        $posts->each(function ($post) {
            if ($post->postImage) {
                $post->postImage = asset('storage/' . $post->postImage);
            } else {
                $post->postImage = 'https://via.placeholder.com/720x480';
            }
        });

        return response()->json($posts);
    }

    public function store(Request $request) {
        $data = $request->validate([
            "title" => "required|min:5",
            "content" => "required|min:30",
            "category_id" => "nullable",
            "tags" => "nullable"
        ]);

        $newPost = new Post();
        $newPost->fill($data);
        $newPost->user_id = 1;
        $newPost->slug = $this->generateUniqueSlug($data['title']);
        $newPost->save();

        if(key_exists('tags', $data)) {
            $newPost->tags()->attach($data['tags']);
        }

        return response()->json($newPost);
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->with(['user', 'category', 'tags'])->first();

        //$post->load('user', 'category', 'tags');

        return response()->json($post);
    }

    public function destroy($slug) {
        $post = Post::where('slug', $slug)->first();

        $post->tags()->detach();

        if ($post->postImage) {
            Storage::delete($post->postImage);
        }

        $post->delete();

        return response()->json();
    }
}
