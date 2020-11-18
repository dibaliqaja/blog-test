<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->middleware('auth');
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::allows('admin-access')) {

            $posts      = Post::latest()->paginate(10);
            $keyword    = $request->keyword;
            if ($keyword)
                $posts  = Post::where('title', 'LIKE', "%$keyword%")
                    ->latest()
                    ->paginate(10);

            return view('posts.index', compact('posts'));

        } else if (Gate::allows('author-access')) {

            $posts = Post::where('users_id', auth()->id())
                ->latest()
                ->paginate(10);
            $keyword = $request->keyword;
            if ($keyword)
                $posts = Post::where('title', 'LIKE', "%$keyword%")
                    ->where('users_id', auth()->id())
                    ->latest()
                    ->paginate(10);

            return view('posts.index', compact('posts'));
        }

        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->image;
            $input['image_name'] = 'img-'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('storage/thumbnails');
            $img = Image::make($image->getRealPath());
            $img->resize(200, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            File::exists($destinationPath) or File::makeDirectory($destinationPath);
            $img->save($destinationPath.'/th-'.$input['image_name']);

            $destinationPath = public_path('storage/images');
            $image->move($destinationPath, $input['image_name']);

            $validatedData              = $request->validated();
            $validatedData['image']     = $input['image_name'];
            $validatedData['thumbnail'] = $img->basename;
            $validatedData['slug']      = Str::slug($request->title)."-".Auth::id();
            $validatedData['users_id']  = Auth::id();
            $this->post->create($validatedData);
        } else {
            $validatedData              = $request->validated();
            $validatedData['slug']      = Str::slug($request->title)."-".Auth::id();
            $validatedData['users_id']  = Auth::id();
            $this->post->create($validatedData);
        }

        return redirect()->route('posts.index')->with('alert','Post addedd successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($this->hasAccess($post->users_id)) {
            $categories = Category::all();
            return view('posts.edit', compact('post', 'categories'));
        }

        abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($this->hasAccess($post->users_id)) {
            if ($request->hasFile('image')) {
                $image_path     = public_path('storage/images/'.$post->image);
                $thumbnail_path = public_path('storage/thumbnails/'.$post->thumbnail);
                if(File::exists($image_path, $thumbnail_path)) File::delete($image_path, $thumbnail_path);

                $image = $request->image;
                $input['image_name'] = 'img-'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('storage/thumbnails');
                $img = Image::make($image->getRealPath());
                $img->resize(200, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
                File::exists($destinationPath) or File::makeDirectory($destinationPath);
                $img->save($destinationPath.'/th-'.$input['image_name']);

                $destinationPath = public_path('storage/images');
                $image->move($destinationPath, $input['image_name']);

                $validatedData              = $request->validated();
                $validatedData['image']     = $input['image_name'];
                $validatedData['thumbnail'] = $img->basename;
                $validatedData['slug']      = Str::slug($request->title)."-".$post->users_id;
                $post->update($validatedData);
            } else {
                $validatedData              = $request->validated();
                $validatedData['slug']      = Str::slug($request->title)."-".$post->users_id;
                $post->update($validatedData);
            }

            return redirect()->route('posts.index')->with('alert', 'Post updated successfully.');
        }

        abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($this->hasAccess($post->users_id)) {
            $image_path     = public_path('storage/images/'.$post->image);
            $thumbnail_path = public_path('storage/thumbnails/'.$post->thumbnail);
            if(File::exists($image_path, $thumbnail_path)) File::delete($image_path, $thumbnail_path);

            $post->delete();

            return redirect()->back()->with('alert','Post deleted successfully.');
        }

        abort(401);
    }

    protected function hasAccess($id)
    {
        return Auth::user()->id == $id || Gate::allows('admin-access');
    }
}
