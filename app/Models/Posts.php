<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Comments;
use App\Models\PostUploads;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class Posts extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id', 'title', 'post', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id')->with(['usr', 'replies'])->whereNull('comment_id');
        // return $this->belongsToMany(Comments::class, 'id', 'post_id')->with('comment_uploads');
    }
    public function uploads()
    {
        return $this->hasMany(PostUploads::class, 'post_id', 'id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id', 'id');
    }
    public function voted()
    {
        $user  = Auth::user()->id;
        return $this->hasOne(Vote::class, 'post_id', 'id')->where('user_id', $user);
    }
    // public function comments()
    // {
    //     return $this->hasOne(User::class, 'user_id', 'id');
    // }
}
