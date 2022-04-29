<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Rating;
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
        $categories   = Category::all();
        $detail       = $post->with('ratings')->where('slug', $slug)->first();
        $take_posts   = $this->takePost($post);
        $rating_count = Rating::where('posts_id', $detail->id)->count();
        $rating_1     = Rating::where('posts_id', $detail->id)->where('star_rating', 1)->count() * 1;
        $rating_2     = Rating::where('posts_id', $detail->id)->where('star_rating', 2)->count() * 2;
        $rating_3     = Rating::where('posts_id', $detail->id)->where('star_rating', 3)->count() * 3;
        $rating_4     = Rating::where('posts_id', $detail->id)->where('star_rating', 4)->count() * 4;
        $rating_5     = Rating::where('posts_id', $detail->id)->where('star_rating', 5)->count() * 5;
        $score_total  = $rating_5 + $rating_4 + $rating_3 + $rating_2 + $rating_1;
        $score_total == 0 ? $response_total = 0 : $response_total = $score_total / $rating_count;

        return view('layout_blog.detail',
            compact(
                'detail',
                'take_posts',
                'categories',
                'rating_count',
                'response_total'
            )
        );
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


    public function ratingPost(Request $request)
    {
        $validated = $this->validate($request, [
            'posts_id'    => 'required|exists:posts,id',
            'users_id'    => 'required|exists:users,id',
            'comments'    => 'string',
            'star_rating' => 'required|integer',
        ]);

        Rating::create($validated);

        return redirect()->back()->with('alert','Your review has been submitted Successfully');
    }

    protected function takePost($post)
    {
        return $post->latest()->take(2)->get();
    }
}
