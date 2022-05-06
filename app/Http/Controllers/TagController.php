<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (Gate::allows('author-access')) return $next($request);
            abort(403);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags    = Tag::latest()->paginate(10);
        $keyword = $request->keyword;
        if ($keyword)
            $tags = Tag::where('name', 'LIKE', "%$keyword%")
                ->latest()
                ->paginate(10);

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = new Tag;
        $tag->create($request->validated());

        return redirect()->route('tags.index')
            ->with('alert', 'Tag added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\TagRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->validated());

        return redirect()->route('tags.index')
            ->with('alert','Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return redirect()->back()->with('alert','Tag deleted successfully.');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('alert','Tag still used in Posts');
        }
    }
}
