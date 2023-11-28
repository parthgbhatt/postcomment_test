@extends('layouts.app')
@section('content')
<style>
    .rounded-image {
        border-radius: 50% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 30px;
        width: 30px;
        margin: 5px;
    }
</style>
<div class="container">

    <div class="wrapper">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    <section class="post">
        <header>Create Post</header>
        <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <!-- <img src="{{ URL::asset('icons/logo.png'); }}" alt="logo"> -->
                <div class="details">
                    <p> {{ $login_user->name }}</p>
                </div>
            </div>
            <input type="text" name="title" class="form-control" placeholder="Title">
            @if ($errors->has('title'))
            <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
            <textarea placeholder="What's on your mind?" spellcheck="false" name="post" required class="m-2"></textarea>
            @if ($errors->has('post'))
            <span class="text-danger">{{ $errors->first('post') }}</span>
            @endif
            <div class="options">
                <input type="file" name="photos[]" multiple>
            </div>
            @if ($errors->has('photos'))
            <span class="text-danger">{{ $errors->first('photos') }}</span>
            @endif
            <button type="submit">Post</button>
        </form>
    </section>
    <section style="background-color: #eee;">
        <div class="container my-5 py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    @foreach($posts as $post)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex flex-start ">
                                <img class="rounded-circle shadow-1-strong me-3" src="{{asset('icons/user.png')}}" alt="avatar" width="60" height="60" />
                                <div>
                                    <h6 class="fw-bold text-primary mb-1">{{$post->user_detail->name}}</h6>
                                    <p class="text-muted small mb-0">
                                        Posted on {{date('d-m-Y H:i',strtotime($post->created_at))}}
                                    </p>
                                </div>
                                @if($login_user->id === $post->user_id)
                                <div style="margin-left: 300px;">
                                    <a href="{{route('post.edit',$post->id)}}">Edit</a>
                                    <a href="{{route('post.delete',$post->id)}}">Delete</a>
                                </div>
                                @endif
                            </div>
                            <h4 class="mt-3 mb-1">{{$post->title}}</h4>
                            <p class="mt-3 mb-4">{{$post->post}}</p>
                            <p class="mt-3 mb-4">
                                @foreach($post->uploads as $image)
                                <img src="{{url('/images/'.$image->file_path)}}" height="150" width="150" style="margin: 5px; border:2px solid black;">
                                @endforeach
                            </p>
                            <div class="small d-flex justify-content-start align-items-center" style="background-color: #fff;border:1px solid #ddd;padding:8px;">
                                <a href="{{route('vote.store',$post->id)}}" class="d-flex  me-3 align-items-center" style="text-decoration:none;">
                                    <i class="{{ $post->voted ?'fa':'far'}} fa-thumbs-up me-2"></i>
                                    <p class="mb-0">Like {{sizeof($post->votes)}}</p>
                                </a>
                                <a href="#" class="d-flex  me-3 align-items-center" style="text-decoration:none;">
                                    <i class="fa fa-comment me-2"></i>
                                    <p class="mb-0">Comments {{sizeof($post->comments)}}</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="card no-border">
                                <div class="card-body p-4">

                                    <div class="row">
                                        <div class="col">
                                            @foreach($post->comments as $comment)
                                            <div class="d-flex flex-start mb-4">
                                                <img class="rounded-circle shadow-1-strong me-3" src="{{asset('icons/user.png')}}" alt="avatar" width="65" height="65" />
                                                <div class="flex-grow-1 flex-shrink-1">
                                                    <div>
                                                        <div class="d-flex justify-content-between ">
                                                            <p class="mb-1">
                                                                {{$comment->usr->name}} <span class="small">- {{date('d-m-Y H:i',strtotime($comment->created_at))}}</span>
                                                            </p>


                                                        </div>
                                                        <p class="small mb-0" style="float:left;">
                                                            {{$comment->comment}}
                                                        </p>
                                                        @if($comment->user_id === $login_user->id)
                                                        <a href="{{route('comment.delete',$comment->id)}}" style="float:left;margin-left: 50px;"><span class="small"> Delete</span></a>
                                                        @endif
                                                        <a href="" class="creply" style="float:left;margin-left: 10px;"><span class="small"> Reply</span></a>

                                                    </div>
                                                    <div class="comment_form" style="list-style: none; display: none">
                                                        <div class="d-flex flex-start mt-4">
                                                            <a class="me-3" href="#">
                                                                <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                            </a>
                                                            <div class="flex-grow-1 flex-shrink-1 mb-3">
                                                                <div>
                                                                    <div class="d-flex justify-content-between ">
                                                                        <p class="mb-1">
                                                                            {{$login_user->name}}
                                                                        </p>
                                                                    </div>

                                                                    <form action="{{route('comment.reply.create',$comment->id)}}" method="post">
                                                                        @csrf
                                                                        <input name="comment" class="form-control" type="text" style="width: 65%;float:left;" />
                                                                        <input name="post_id" type="hidden" style="width: 65%;float:left;" value="{{$post->id}}" />
                                                                        <button type="submit" class="btn btn-primary" style="width: 30%;height:37px;float:right;background-color: transparent;color:blue"><i class="far fa-paper-plane"></i></button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @foreach($comment->replies as $reply)
                                                    <div class="d-flex flex-start mt-4">
                                                        <a class="me-3" href="#">
                                                            <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                        </a>
                                                        <div class="flex-grow-1 flex-shrink-1">
                                                            <div>
                                                                <div class="d-flex justify-content-between ">
                                                                    <p class="mb-1">
                                                                        {{$reply->usr->name}} <span class="small">- {{date('d-m-Y H:i',strtotime($reply->created_at))}}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="d-flex justify-content-between ">
                                                                    <p class="small mb-0">
                                                                        {{$reply->comment}}
                                                                    </p>
                                                                    @if($reply->user_id === $login_user->id)
                                                                    <a href="{{route('comment.delete',$reply->id)}}"><span class="small">Delete</span></a>
                                                                    @endif
                                                                    <a href="" class="creply"><span class="small"> Reply</span></a>
                                                                </div>
                                                                <div class="comment_form" style="list-style: none; display: none">
                                                                    <div class="d-flex flex-start mt-4">
                                                                        <a class="me-3" href="#">
                                                                            <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                                        </a>
                                                                        <div class="flex-grow-1 flex-shrink-1 mb-3">
                                                                            <div>
                                                                                <div class="d-flex justify-content-between ">
                                                                                    <p class="mb-1">
                                                                                        {{$login_user->name}}
                                                                                    </p>
                                                                                </div>

                                                                                <form action="{{route('comment.reply.create',$reply->id)}}" method="post">
                                                                                    @csrf
                                                                                    <input name="comment" class="form-control" type="text" style="width: 65%;float:left;" />
                                                                                    <input name="post_id" type="hidden" style="width: 65%;float:left;" value="{{$post->id}}" />
                                                                                    <button type="submit" class="btn btn-primary" style="width: 30%;height:37px;float:right;background-color: transparent;color:blue"><i class="far fa-paper-plane"></i></button>
                                                                                </form>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if(sizeof($reply->replies) > 0)
                                                                @foreach($reply->replies as $creply)
                                                                <div class="d-flex flex-start mt-4">
                                                                    <a class="me-3" href="#">
                                                                        <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                                    </a>
                                                                    <div class="flex-grow-1 flex-shrink-1">
                                                                        <div>
                                                                            <div class="d-flex justify-content-between ">
                                                                                <p class="mb-1">
                                                                                    {{$creply->usr->name}} <span class="small">- {{date('d-m-Y H:i',strtotime($creply->created_at))}}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between ">
                                                                                <p class="small mb-0">
                                                                                    {{$creply->comment}}
                                                                                </p>
                                                                                @if($creply->user_id === $login_user->id)
                                                                                <a href="{{route('comment.delete',$creply->id)}}" style="margin-left: 50px;"><span class="small">Delete</span></a>
                                                                                @endif
                                                                                <a href="" class="creply"><span class="small" style="margin-left: 10px;"> Reply</span></a>
                                                                            </div>
                                                                            <div class="comment_form" style="list-style: none; display: none">
                                                                                <div class="d-flex flex-start mt-4">
                                                                                    <a class="me-3" href="#">
                                                                                        <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                                                    </a>
                                                                                    <div class="flex-grow-1 flex-shrink-1 mb-3">
                                                                                        <div>
                                                                                            <div class="d-flex justify-content-between ">
                                                                                                <p class="mb-1">
                                                                                                    {{$login_user->name}}
                                                                                                </p>
                                                                                            </div>

                                                                                            <form action="{{route('comment.reply.create',$creply->id)}}" method="post">
                                                                                                @csrf
                                                                                                <input name="comment" class="form-control" type="text" style="width: 65%;float:left;" />
                                                                                                <input name="post_id" type="hidden" style="width: 65%;float:left;" value="{{$post->id}}" />
                                                                                                <button type="submit" class="btn btn-primary" style="width: 30%;height:37px;float:right;background-color: transparent;color:blue"><i class="far fa-paper-plane"></i></button>
                                                                                            </form>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @if(sizeof($creply->replies) > 0)
                                                                            @foreach($creply->replies as $thirdReply)
                                                                            <div class="d-flex flex-start mt-4">
                                                                                <a class="me-3" href="#">
                                                                                    <img class="rounded-circle shadow-1-strong" src="{{asset('icons/user.png')}}" alt="avatar" width="30" height="30" />
                                                                                </a>
                                                                                <div class="flex-grow-1 flex-shrink-1">
                                                                                    <div>
                                                                                        <div class="d-flex justify-content-between ">
                                                                                            <p class="mb-1">
                                                                                                {{$thirdReply->usr->name}} <span class="small">- {{date('d-m-Y H:i',strtotime($thirdReply->created_at))}}</span>
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-between ">
                                                                                            <p class="small mb-0">
                                                                                                {{$thirdReply->comment}}
                                                                                            </p>
                                                                                            @if($thirdReply->user_id === $login_user->id)
                                                                                            <a href="{{route('comment.delete',$thirdReply->id)}}" style="margin-left: 50px;"><span class="small">Delete</span></a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{route('comment.create',$post->id)}}" class="pb-3" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                <div class="d-flex flex-start w-100">
                                    <img class="rounded-circle shadow-1-strong me-3" src="{{asset('icons/user.png')}}" alt="avatar" width="40" height="40" />
                                    <div class="form-outline w-100">
                                        <input type="text" name="comment" class="form-control" placeholder="comment">
                                    </div>
                                    <div class="input--file mt-1">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="3.2" />
                                                <path d="M9 2l-1.83 2h-3.17c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-12c0-1.1-.9-2-2-2h-3.17l-1.83-2h-6zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z" />
                                                <path d="M0 0h24v24h-24z" fill="none" />
                                            </svg>
                                        </span>
                                        <input name="Select File" type="file" name="commentfiles[]" multiple />
                                    </div>

                                </div>
                                <div class="float-end mt-1" style="margin-left:10px;">
                                    <button type="submit" class="btn btn-primary btn-sm float-left" style="width:100px;height:30px;">Post comment</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm float-left" style="width:100px;height:30px;">Cancel</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
