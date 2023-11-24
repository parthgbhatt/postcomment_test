<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CommentUploads;

class Comments extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id', 'post_id', 'comment_id', 'comment', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    public function comment_uploads()
    {
        return $this->hasMany(CommentUploads::class, 'comment_id', 'id');
    }
}
