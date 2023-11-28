<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vote;

class VoteController extends Controller
{
    public function __construct()
    {
        $login_user = Auth::user();
        $this->middleware('auth');
    }
    public function store($post_id)
    {
        $user_id = Auth::user()->id;

        $checkPost = Vote::where(['post_id' => $post_id, 'user_id' => $user_id])->get();
        if (sizeof($checkPost) == 1) {
            Vote::where(['post_id' => $post_id, 'user_id' => $user_id])->delete();
            return back()->with('success', 'Removed Vote');
        } else {
            $vote = new Vote();
            $vote->post_id = $post_id;
            $vote->user_id = $user_id;
            $vote->save();
            return back()->with('success', 'Vote Success.');
        }
    }
}
