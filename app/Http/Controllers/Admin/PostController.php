<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->getPosts();
        return view('posts.index', compact('posts'));
    }
    
    public function create()
    {
        cache()->remember('categorias', 60*60, function () {
            return \DB::table('categories')->where('status', true)->get();
        });
        return view('posta.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required',
        'image' => 'mimes:jpeg,jpg,png,gif|required|max:50000',
        'status' => 'required'
    ]);

    try {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('posts', 'public');

            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => isset($image) ? $image : 'dummy.jpg',
                'status' => $request->status
            ]);

            return redirect()->route('post.index')->with('message', 'Post successfully created!');
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return to_route('post.index')->with('message', 'Post successfully deleted!');
    }

    public function getPosts()
    {
        return \DB::table('posts')
            ->where('posts.status', true)
            ->join('categories', 'categories.id', 'posts.category_id')
            ->select('posts.*', 'categories.category_name as category_name')
            ->orderByDesc('id')
            ->get();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = \DB::table('categories')->where('status', true)->get();
        return view ('post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required',
            'image'=> 'mimes:jpeg,jpg,png,gif|max:50000',
            'status' => 'required'
        ]);
        try {
            $post = Post:: findOrFail($id);
            if ($request->hasFile('image')) {
                //if received
                $image = $request->file('image')->store('post', 'public');
            }else{
                //if not received new image set as old one
                $image = $post->image;
            }
            $post->update([
                'title'=>$request->title,
                'description' => $request->description,
                'category_id' => $request->category,
                'image'=> isset($image)? $image:'dummy.jpg',
                'status' => $request->status
            ]);
            return to_route('post.index')->with('message', 'Post successfully updated!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}