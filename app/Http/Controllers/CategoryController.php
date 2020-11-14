<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $categories = Category::where('users_id', auth()->id())->latest()->paginate(10);
        $user = Auth::user()->id;
        $keyword  = $request->get('keyword');
        if ($keyword) {
            $categories = Category::where('name', 'LIKE', "%$keyword%")
                ->where('users_id', auth()->id())
                ->paginate(10);
        }

        return view('categories.index', compact('categories', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'name' => 'required|unique:categories|min:5',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'users_id' => Auth::id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories|min:5',
        ]);


        $category_data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'users_id' => Auth::id(),
        ];

        Category::whereId($category->id)->update($category_data);

        return redirect()->route('categories.index')->with('success','Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()->back()->with('success','Category deleted successfully.');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('success','Category still used in Posts');
        }
    }
}
