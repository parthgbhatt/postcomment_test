<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\PostUploads;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function __construct()
    {
        $login_user = Auth::user();
        $this->middleware('auth');
    }
    public function index()
    {
        $login_user = Auth::user();
        $posts = Posts::with(['user_detail', 'comments'])->where('deleted_at', NULL)->orderBy('created_at', 'ASC')->get();
        return view('posts.index', compact('login_user', 'posts'));
    }
    public function create(Request $request)
    {
        $login_user = Auth::user();
        $this->validate($request, [
            'title' => 'required',
            'post' => 'required|min:20|max:255',
            // 'photos' => 'mimes:jpeg,png,jpg,gif,mp4|size:1024'
        ]);

        $post = new Posts();
        $post->title = $request->title;
        $post->post = $request->post;
        $post->user_id = $login_user->id;
        $post->save();

        $images = array();
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            foreach ($files as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $file->move(public_path('images'), $image_full_name);
                $images[] = $image_full_name;
            }
        }
        foreach ($images as $img) {
            $post_img = new PostUploads();
            $post_img->file_path = $img;
            $post_img->post_id = $post->id;
            $post_img->user_id = $login_user->id;
            $post_img->save();
        }
        return back()->with('success', 'You have successfully post');
    }
}
