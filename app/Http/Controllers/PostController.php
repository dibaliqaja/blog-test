<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('users_id', auth()->id())->latest()->paginate(10);
        $user = Auth::user()->id;
        $keyword  = $request->get('keyword');
        if ($keyword) {
            $posts = Post::where('title', 'LIKE', "%$keyword%")
                ->where('users_id', auth()->id())
                ->paginate(10);
        }

        return view('posts.index', compact('posts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->where('users_id', auth()->id());
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'             => 'required|min:5',
            'short_description' => 'required|min:5',
            'content'           => 'required',
            'image'             => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'category_id'       => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->image;
            $new_image = 'img-'.time().'.'.$image->getClientOriginalExtension();
            $thumbnail = Image::make($image->getRealPath())->resize(250, 125);
            $new_thumbnail = $thumbnail->save(public_path('storage/thumbnails/th-'.$new_image));
            $image->move('storage/images/', $new_image);

            Post::create([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'image'             => $new_image,
                'thumbnail'         => $new_thumbnail->basename,
                'category_id'       => $request->category_id,
                'users_id'           => Auth::id(),
            ]);

        } else {
            Post::create([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'category_id'       => $request->category_id,
                'users_id'           => Auth::id(),
            ]);
        }

        return redirect()->route('posts.index')->with('success','Post addedd successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all()->where('users_id', auth()->id());
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title'             => 'required|min:5',
            'short_description' => 'required|min:5',
            'content'           => 'required',
            'image'             => 'image|mimes:jpeg,png,jpg|max:1024',
            'category_id'       => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->image;
            $new_image = 'img-'.time().'.'.$image->getClientOriginalExtension();
            $thumbnail = Image::make($image->getRealPath())->resize(250, 125);
            $new_thumbnail = $thumbnail->save(public_path('storage/thumbnails/th-'.$new_image));
            $image->move('storage/images/', $new_image);

            $post->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'image'             => $new_image,
                'thumbnail'         => $new_thumbnail->basename,
                'category_id'       => $request->category_id,
                'users_id'           => Auth::id(),
            ]);
        } else {
            $post->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title),
                'short_description' => $request->short_description,
                'content'           => $request->content,
                'category_id'       => $request->category_id,
                'users_id'           => Auth::id(),
            ]);
        }

        return redirect()->route('posts.index')->with('success','Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $image_path     = public_path('storage/images/'.$post->image);
        $thumbnail_path = public_path('storage/thumbnails/'.$post->thumbnail);
        if(File::exists($image_path, $thumbnail_path)) File::delete($image_path, $thumbnail_path);

        $post->delete();

        return redirect()->back()->with('success','Post deleted successfully.');
    }
}
