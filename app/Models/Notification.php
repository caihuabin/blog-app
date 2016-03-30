<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\Blog, App\Models\Reply;

class Notification extends Model
{

	// Don't forget to fill this array
	protected $table = 'notifications';
	protected $fillable = [
			'from_user_id',
			'user_id',
			'blog_id',
			'reply_id',
			'noti_body',
			'type'
			];

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function blog()
	{
		return $this->belongsTo('App\Models\Blog', 'blog_id', 'id');
	}

	public function fromUser()
	{
		return $this->belongsTo('App\User', 'from_user_id', 'id');
	}

	/**
	 * Create a notification
	 * @param  [type] $type     currently have 'at', 'new_reply', 'attention'
	 * @param  User   $fromUser come from who
	 * @param  array   $users   to who, array of users
	 * @param  Blog  $blog    cuurent context
	 * @param  Reply  $reply    the content
	 * @return [type]           none
	 */
	public static function batchNotify($type, $fromUser_id, $users, Blog $blog, Reply $reply = null)
	{
		$nowTimestamp = Carbon::now()->toDateTimeString();
		$data = [];

		foreach ($users as $toUser)
		{
			if ($fromUser_id == $toUser->id)
				continue;

			$data[] = [
				'from_user_id' => $fromUser_id,
				'user_id'      => $toUser->id,
				'blog_id'   => $blog->id,
				'reply_id'     => $reply->id,
				'noti_body'    => $reply->reply_body,
				'type'         => $type,
				'created_at'   => $nowTimestamp,
				'updated_at'   => $nowTimestamp
			];

			$toUser->increment('notification_count', 1);
		}

        if (count($data)) {
            Notification::insert($data);
        }
	}

    public static function notify($type, $fromUser_id, $toUser, Blog $blog, Reply $reply = null)
    {
        if ($fromUser_id == $toUser->id)
            return;

        if (Notification::isNotified($fromUser_id, $toUser->id, $blog->id, $type))
            return;

        $nowTimestamp = Carbon::now()->toDateTimeString();

        $data[] = [
            'from_user_id' => $fromUser_id,
            'user_id'      => $toUser->id,
            'blog_id'   => $blog->id,
            'reply_id'     => $reply ? $reply->id : 0,
            'noti_body'    => $reply ? $reply->reply_body : '',
            'type'         => $type,
            'created_at'   => $nowTimestamp,
            'updated_at'   => $nowTimestamp
        ];

        $toUser->increment('notification_count', 1);

        Notification::insert($data);
    }

    public static function isNotified($from_user_id, $user_id, $blog_id, $type)
    {	
        return Notification::fromWhom($from_user_id)
                        ->toWhom($user_id)
                        ->atBlog($blog_id)
                        ->withType($type)->count();
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function scopeFromWhom($query, $from_user_id)
    {
        return $query->where('from_user_id', '=', $from_user_id);
    }

    public function scopeToWhom($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

    public function scopeWithType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeAtBlog($query, $blog_id)
    {
        return $query->where('blog_id', '=', $blog_id);
    }


}
