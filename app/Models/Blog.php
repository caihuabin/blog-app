<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache, Carbon\Carbon;

class Blog extends Model
{

	protected $table = 'blogs';
	protected $fillable = [ 'title', 'blog_body', 'image_list', 'user_id', 'last_reply_user_id'];
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    /*    
    public function getDates()
    {
        return ['valid_at', 'expired_at'];
    }
*/
    protected $casts = [
        'image_list' => 'array'
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function replys()
    {
        return $this->hasMany('App\Models\Reply', 'blog_id', 'id');
    }

    public function lastReplyUser()
    {
        return $this->belongsTo('App\User', 'last_reply_user_id', 'id');
    }


    public function votes()
    {
        return $this->morphMany('App\Models\Vote', 'votable');
    }
    
    public function generateLastReplyUserInfo()
    {
        $lastReply = $this->replys()->recent()->first();

        $this->last_reply_user_id = $lastReply ? $lastReply->user_id : 0;
        $this->save();
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }

}
