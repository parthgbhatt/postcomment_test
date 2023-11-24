@extends('layouts.app')
@section('content')
<div class="container">

    <div class="wrapper">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
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
                <textarea placeholder="What's on your mind?" spellcheck="false" name="post" required></textarea>
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
    </div>
    <hr>
    @foreach($posts as $post)
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <h5>{{$post->user_detail->name}}</h5>

            </div>
            <div class="col-md-6">
                <span>{{date('d-m-Y H:i:s',strtotime($post->created_at))}}<span>
            </div>
        </div>
        <div class="col-md-12">
            <h3>{{$post->title}}</h3>
            <p>{{$post->post}}</p>
            </div2>
        </div>
        <hr>
        <!-- <div class="panel panel-default">
        <div class="panel-body">
            <section class="post-heading">
                <div class="row">
                    <div class="col-md-11">
                        <div class="media">
                            <div class="media-body">
                                <a href="#" class="anchor-username">
                                    <h5 class="media-heading">{{$post->user_detail->name}}</h5>
                                </a>
                                <span>{{date('d-m-Y H:i:s',strtotime($post->created_at))}}<span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="post-body">
                <h3>{{$post->title}}</h3>
                <p>{{$post->post}}</p>
            </section>
            <section class="post-footer">
                <div class="post-footer-option container">
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> Like</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-comment"></i> Comment</a></li>
                    </ul>
                </div>
            </section>
        </div>
    </div> -->
        @endforeach
        <hr>

    </div>
    @endsection
