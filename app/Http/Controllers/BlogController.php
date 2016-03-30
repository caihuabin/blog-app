<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App, DB, Validator, Input, Redirect, Carbon\Carbon, Session, Auth;
use App\Http\Controllers\Controller;

use App\Models\Blog, App\Models\Reply;

class BlogController extends Controller
{

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
            ]);
    }
/*
$dates->load(['services' => function($query)
{
    $query->orderBy('published_date', 'asc');
}]);
*/
    public function index()
    {
        $blogs = Blog::recent()
                ->with(['user', 'lastReplyUser'])
                ->simplePaginate(5)
                ->setPath('blog');
        return view('mobile.blog.index', ['blogs' => $blogs]);
    }

    //response()->view('hello')->header('Content-Type', $type)->withCookie(cookie('name', 'value'));

    public function create()
    {
        return view('mobile.blog.create');
    }

    public function store(Request $request)
    {   

        $rules = array(
            'title' => 'required|max:100',
            'blog_body' => 'required',
            'image_list' => 'array',
        );
        $validation = Validator::make($request->except('_token'), $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withInput($request->except('_token'))->withErrors($validation);
        }

        $data = $request->only(['title', 'blog_body', 'image_list']);

        $data['user_id'] = Auth::user()->id;
        $data['last_reply_user_id'] = $data['user_id'];

        $service = Blog::create($data);
        if ( ! $service)
        {
            return Response::make('Unauthorized', 401);
        }
        return redirect('/');
    }

    public function show($id)
    {

        $blog = Blog::where('id', $id)->with('user')->firstOrFail();
        $replies = Reply::where('blog_id', $blog->id)
            ->where('reply_id', 0)
            ->with(['replys' => function($query){
                        $query->orderBy('created_at', 'asc');
                    }])
            ->orderBy('created_at', 'asc')
            ->simplePaginate(5);

        $blog->increment('view_count', 1);

        return view('mobile.blog.show', ['blog' => $blog, 'replies' => $replies]);
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $this->ownerOrAdminRequire($blog->user_id);
        return view('mobile.blog.edit', ['blog' => $blog]);
    }

    public function update($id)
    {
        $blog = Blog::findOrFail($id);
        $this->ownerOrAdminRequire($blog->user_id);
        $rules = array(
            'title' => 'required|max:100',
            'blog_body' => 'required',
            'image_list' => 'array',
        );
        $validation = Validator::make(Input::except('_token'), $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withInput($request->except('_token'))->withErrors($validation);
        }

        $data = Input::only(['title', 'blog_body', 'image_list']);
        $blog->update($data);
        return redirect()->route('blog.show', ['id' => $blog->id]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $this->ownerOrAdminRequire($blog->user_id);
        $blog->delete();
        $user = $blog->user;
        $user->decrement('blog_count', 1);
        return redirect()->route('home');
    }

    public function vote($id)
    {   
        $blog = Blog::findOrFail($id);
        App::make('App\Blog\Vote\Voter')->blogVote($blog);
        return redirect()->route('blog.show', $blog->id);
    }
    
}
