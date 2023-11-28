<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentUploads;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function  create(Request $request, $post_id)
    {
        $login_user = Auth::user();
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $comment = new Comments();
        $comment->user_id = $login_user->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->comment;
        $comment->save();

        $images = array();
        if ($request->hasFile('commentfiles')) {
            $files = $request->file('commentfiles');
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $file->move(public_path('commentscomments'), $image_full_name);
                $images[] = $image_full_name;
            }
        }
        foreach ($images as $img) {
            $post_img = new CommentUploads();
            $post_img->file_path = $img;
            $post_img->comment_id = $comment->id;
            $post_img->user_id = $login_user->id;
            $post_img->save();
        }


        return back()->with('success', 'Comment successfull');
    }
    public function  commentReply(Request $request, $comment_id)
    {
        $login_user = Auth::user();
        $this->validate($request, [
            'post_id' => 'required',
            'comment' => 'required',
        ]);
        $comment = new Comments();
        $comment->user_id = $login_user->id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->comment_id = $comment_id;
        $comment->save();
        return back()->with('success', 'Comment successfull');
    }
    public function deleteComment($commentId)
    {
        $login_user = Auth::user();
        $comment = Comments::find($commentId)->delete();

        return back()->with('success', 'Comment deleted successfull');
    }
}
