<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CommentUploads;
use App\Models\User;

class Comments extends Model
{
    use HasFactory;
    public $fillable = ['id', 'post_id', 'comment_id', 'comment', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    public function comment_uploads()
    {
        return $this->hasMany(CommentUploads::class, 'comment_id', 'id');
    }
    public function usr()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(Comments::class, 'comment_id', 'id')->with(['usr', 'comment_uploads'])->orderBy('id', 'ASC');
    }
    // public function deleteReplies()
    // {
    //     $this->replies->each->delete();
    // }
}
