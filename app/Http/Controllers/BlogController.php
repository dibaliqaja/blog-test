<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Post $post)
    {
        $posts_data = $post->latest()->paginate(6);
        $take_posts = $post->latest()->take(2)->get();

        return view('layout_blog.index', compact('posts_data','take_posts'));
    }

    public function detail($slug, Post $post)
    {
        $categories = Category::all();
        $detail = $post->where('slug', $slug)->first();
        $take_posts = $post->latest()->take(2)->get();

        return view('layout_blog.detail', compact('detail','take_posts','categories'));
    }

    public function categories(Category $category, Post $post)
    {
        $list = $category->posts()->count() >= 1;

        if ($list) {
            $take_posts = $post->latest()->take(2)->get();
            $posts_data = $category->posts()->paginate(5);
            return view('layout_blog.index', compact('posts_data','take_posts'));
        }

        $take_posts = $post->latest()->take(2)->get();
        return view('layout_blog.notpost', compact('take_posts'));
    }

    public function search(Request $request, Post $post)
    {
        $data = $post->where('title', $request->search)->orWhere('title','like','%'.$request->search.'%')->count() >= 1;

        if ($data) {
            $take_posts = $post->latest()->take(2)->get();
            $posts_data = $post->where('title', $request->search)->orWhere('title','like','%'.$request->search.'%')->paginate(5);
            return view('layout_blog.index', compact('take_posts','posts_data'));
        }

        $take_posts = $post->latest()->take(2)->get();
        return view('layout_blog.notpost', compact('take_posts'));
    }
}
