<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::orderBy('created_at', 'DESC')->get()->all();
    }

    public function get($id)
    {
        return Post::find($id);
    }

    public function create(Request $request)
    {   
        if (!Auth::check()) {
            abort(401, 'You need to be a connected user to create a Post');
        }
        return Post::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()->name,
            'body' => $request->body,
            'title' => $request->title
        ]);
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            abort(401, 'You need to be a connected user to delete a Post');
        }
        $post = Post::find($id);
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not authorised to delete this Post ');
        }
        Post::destroy($id);
        return $id;
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            abort(401, 'You need to be a connected user to update a Post');
        }
        $post = Post::find($request->_id);
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not authorised to update this Post ');
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return $post;
    }
}
