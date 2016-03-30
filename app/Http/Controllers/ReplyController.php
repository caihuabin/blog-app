<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, Carbon\Carbon, Validator, App, Session, Auth;

use App\Models\Reply, App\Models\Blog;
use App\Blog\Notification\Mention;

class ReplyController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'destroy']]);
    }

	public function store(Request $request)
	{
        $rules = array(
            'reply_body'     => 'required|min:2',
            'blog_id' => 'required|numeric',
            'reply_id' => 'required|numeric',
        );
        $validation = Validator::make($request->except('_token'), $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withInput($request->except('_token'))->withErrors($validation);
        }
        $data = $request->only(['reply_body', 'blog_id', 'reply_id']);
        $blog= Blog::findOrFail($data['blog_id']);

        $currentUser = Auth::user();
        $mentionParser = App::make('App\Blog\Notification\Mention');
        $data['user_id'] = $currentUser->id;
        $data['reply_body'] = $mentionParser->parse($data['reply_body']);
        $reply = Reply::create($data);
        if ( ! $reply)
        {
            return Response::make('Unauthorized', 401);
        }

        $blog->reply_count++;
        $blog->updated_at = Carbon::now()->toDateTimeString();
        $blog->save();
        $currentUser->increment('reply_count', 1);
        App::make('App\Blog\Notification\Notifier')->newReplyNotify($currentUser->id, $mentionParser, $blog, $reply);
        return redirect()->back();
	}

    public function vote($id)
    {
        $reply = Reply::findOrFail($id);
        App::make('App\Blog\Vote\Voter')->replyVote($reply);
        /*return redirect()->route('blog.show', [$reply->blog_id, '#reply'.$reply->id]);*/
        return redirect()->back();
    }

    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $this->ownerOrAdminRequire($reply->user_id);
        $reply->delete();
        $reply->blog->decrement('reply_count', 1);
        $reply->user->decrement('reply_count', 1);

        $reply->blog->generateLastReplyUserInfo();
        return redirect()->back();
    }

}
