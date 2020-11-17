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
        $take_posts = $this->takePost($post);

        return view('layout_blog.index', compact('posts_data','take_posts'));
    }

    public function detail($slug, Post $post)
    {
        $categories = Category::all();
        $detail = $post->where('slug', $slug)->first();
        $take_posts = $this->takePost($post);

        return view('layout_blog.detail', compact('detail','take_posts','categories'));
    }

    public function categories(Category $category, Post $post)
    {
        $list = $category->posts()->count() >= 1;
        $take_posts = $this->takePost($post);
        $posts_data = ($list) ? $category->posts()->paginate(5) : [];

        return view('layout_blog.index', compact('posts_data', 'take_posts'));
    }

    public function search(Request $request, Post $post)
    {
        $take_posts = $this->takePost($post);
        $keyword    = $request->search;
        $posts_data = ($keyword)
            ? $post->where('title', 'LIKE', "%$keyword%")->latest()->paginate(5)
            : [];

        return view('layout_blog.index', compact('take_posts','posts_data'));
    }

    protected function takePost($post)
    {
        return $post->latest()->take(2)->get();
    }
}
