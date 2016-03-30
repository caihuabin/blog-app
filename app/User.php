<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.支持批量赋值
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'realname', 'telephone', 'gender', 'city', 'address', 'signature', 'avatar'];
    //不支持批量赋值
    //protected $guarded = [];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function notifications()
    {
        return $this->hasMany('App\Models\Notification')->recent()->with('blog', 'fromUser')->paginate(20);
    }
    
    public function blogs()
    {
        return $this->hasMany('App\Models\Blog', 'user_id', 'id');
    }

    public function replys()
    {
        return $this->hasMany('App\Models\Reply', 'user_id', 'id');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
