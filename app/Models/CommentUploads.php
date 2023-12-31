<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentUploads extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'comment_uploads';
    public $fillable = ['id', 'file_path', 'comment_id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];
}
