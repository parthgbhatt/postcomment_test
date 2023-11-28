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
    </div>
    <section class="post">
        <header>Update Post</header>
        <form action="{{ route('post.update',$post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="content">
                <!-- <img src="{{ URL::asset('icons/logo.png'); }}" alt="logo"> -->
                <div class="details">
                    <p> {{ $login_user->name }}</p>
                </div>
            </div>
            <input type="text" name="title" class="form-control" placeholder="Title" value="{{$post->title}}">
            @if ($errors->has('title'))
            <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
            <textarea placeholder="What's on your mind?" spellcheck="false" name="post" required>{{$post->post}}</textarea>
            @if ($errors->has('post'))
            <span class="text-danger">{{ $errors->first('post') }}</span>
            @endif
            <div class="row">
                @foreach($post->uploads as $image)
                <div class="col-md-2 " style="margin: 5px;">
                    <img src="{{url('/images/'.$image->file_path)}}" height="150" width="150" style="border:2px solid black;">
                    <a href="{{route('post.remove.image',$image->id)}}" class="btn btn-danger">Remove</a>
                </div>
                @endforeach
            </div>
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
@endsection
