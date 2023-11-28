<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/posts', [App\Http\Controllers\PostsController::class, 'index'])->name('posts');
Route::post('/posts', [App\Http\Controllers\PostsController::class, 'create'])->name('post.create');
Route::post('/posts/update/{id}', [App\Http\Controllers\PostsController::class, 'update'])->name('post.update');
Route::get('/posts/edit/{id}', [App\Http\Controllers\PostsController::class, 'edit'])->name('post.edit');
Route::get('/posts/delete/image/{id}', [App\Http\Controllers\PostsController::class, 'removeImage'])->name('post.remove.image');
Route::get('/posts/delete/{id}', [App\Http\Controllers\PostsController::class, 'delete'])->name('post.delete');
Route::get('/vote/store/{id}', [App\Http\Controllers\VoteController::class, 'store'])->name('vote.store');


Route::post('/comment/{post_id}', [App\Http\Controllers\CommentsController::class, 'create'])->name('comment.create');
Route::post('/commentreply/{comment_id}', [App\Http\Controllers\CommentsController::class, 'commentReply'])->name('comment.reply.create');
Route::get('/comment-delete/{comment_id}', [App\Http\Controllers\CommentsController::class, 'deleteComment'])->name('comment.delete');
