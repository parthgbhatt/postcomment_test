<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Comments;

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
        return $this->hasMany(Comments::class, 'post_id', 'id');
        // return $this->belongsToMany(Comments::class, 'id', 'post_id')->with('comment_uploads');
    }
    // public function comments()
    // {
    //     return $this->hasOne(User::class, 'user_id', 'id');
    // }
}
