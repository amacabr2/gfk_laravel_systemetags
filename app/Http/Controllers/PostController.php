<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return $this->renderIndex((new Post())->newQuery());
    }

    /**
     * Show comments with the same tag
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($slug) {
        $tag = Tag::where('slug', $slug)->first();
        return $this->renderIndex($tag->posts());
    }

    /**
     * Show index
     *
     * @param $postQuery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function renderIndex($postQuery) {
        $posts = $postQuery->with('tags')->paginate(5);
        $tags = Tag::all();
        $max = Tag::max('post_count');
        return view('posts.index', [
            'posts' => $posts,
            'tags' => $tags,
            'max' => $max
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest|Request $request
     * @return Response
     */
    public function store(PostRequest $request) {
        $post = Post::create($request->all());
        if ($request->get('tags') != null) {
            $post->saveTags($request->get('tags'));
        }
        return redirect()->route('posts.index')->with('success', 'Article créé');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     * @internal param int $id
     */
    public function edit(Post $post) {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Post $post
     * @return Response
     * @internal param int $id
     */
    public function update(Request $request, Post $post) {
        $post->update($request->all());
        $post->saveTags($request->get('tags'));
        return redirect()->route('posts.index')->with('success', 'Article modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}
