<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
	protected $table = 'replys';
	protected $fillable = [
		'reply_body',
		'user_id',
        'blog_id',
        'reply_id'
	];

    public static function boot()
    {
        parent::boot();
    }

    public function votes()
	{
		return $this->morphMany('App\Models\Vote', 'votable');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function replys(){
		return $this->hasMany('App\Models\Reply', 'reply_id', 'id');
	}

	public function blog()
	{
		return $this->belongsTo('App\Models\Blog');
	}

	public function scopeWhose($query, $user_id)
	{
        return $query->where('user_id','=',$user_id)->with('blog');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }
}
