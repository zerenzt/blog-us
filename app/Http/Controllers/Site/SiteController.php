<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $posts = $this->getPost();
        return view('frontend.home', compact('posts'));
    }

    public function postDetails(Request $request, $id)
    {
        $post = Post::FindOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('frontend.post-detail', compact('post'));
    }

    public function getPosts(){
        return \DB::table('posts')
        ->where('post.status', true)
        ->join('categories', 'categories.id', 'posts.category.id')
        ->select('posts.*', 'categories.category_name as category_name')
        ->orderByDesc('id')
        ->get();
    }
}
