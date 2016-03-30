<?php 
namespace App\Blog\Vote;

use Carbon\Carbon, Session, Response, Auth;
use App\Models\Reply, App\Models\Blog, App\Models\Vote, App\User, App\Models\Notification;

class Voter
{
    public $notifiedUsers = [];

    public function blogVote(Blog $blog)
    {
		$user_id = Auth::user()->id;
        if ($user_id == $blog->user_id) {
            return redirect()->back();
        }
        if ($blog->votes()->ByWhom($user_id)->WithType('upvote')->count()) {
            // click twice for remove upvote
            $blog->votes()->ByWhom($user_id)->WithType('upvote')->delete();
            $blog->decrement('vote_count', 1);
        }
        else {
            // first time click
            $blog->votes()->create(['user_id' => $user_id, 'is' => 'upvote']);
            $blog->increment('vote_count', 1);

            Notification::notify('blog_upvote', $user_id, $blog->user, $blog);
        }
    }
    public function replyVote(Reply $reply)
    {
		$user_id = Auth::user()->id;
        if ($user_id == $reply->user_id) {
            return redirect()->back();
        }

        if ($reply->votes()->ByWhom($user_id)->WithType('upvote')->count()) {
            // click twice for remove upvote
            $reply->votes()->ByWhom($user_id)->WithType('upvote')->delete();
            $reply->decrement('vote_count', 1);
        } 
        else {
            // first time click
            $reply->votes()->create(['user_id' => $user_id, 'is' => 'upvote']);
            $reply->increment('vote_count', 1);

            Notification::notify('reply_upvote', $user_id, $reply->user, $reply->blog, $reply);
        }
    }

}
