@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.partials.alerts')
    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <strong>Posted by :</strong> {{ $thread->user->name }} - {{ $thread->created_at->diffForHumans() }}
                </div>
                <div class="col-md-6 mb-3 text-right">
                    <strong>Last updated :</strong> {{ $thread->updated_at->diffForHumans() }}
                </div>
            </div>
            @if ($thread->user_id === auth()->user()->id)
                <form method="POST" action="{{ route('thread.update', $thread->id) }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                               name="title"  placeholder="Title" value="{{ old('title') ? old('title'): $thread->title }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                                <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                  name="body"  placeholder="Content">{{ old('body') ? old('body'): $thread->body }}</textarea>
                        @if ($errors->has('body'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            @else
                <h3>{{ $thread->title }}</h3>
                <p>{{ $thread->body }}</p>
            @endif
            <hr>
        </div>
        <div class="offset-md-1 col-md-4">
            <h3>Thread collaborators</h3>
            @foreach ($collaborators as $collaborator)
                <span class="badge badge-info">{{ $collaborator->name }}</span>
            @endforeach
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <h3 class="mb-4">Comments</h3>
            @if ($thread->comments()->count())
                @foreach ($thread->comments as $comment)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $comment->user->name }}
                        </div>
                        <div class="col-md-6 mb-3 text-right">
                            {{ $comment->created_at->diffForHumans() }}
                        </div>
                        <div class="col-md-12">
                            <p>{{ $comment->body }}</p>
                        </div>

                    </div>
                    <hr>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <p>This thread has no comments yet !</p>
                </div>
            @endif
        </div>
        <div class="offset-md-1 col-md-4">
            <h3>Post a Comment</h3>
            <form method="POST" action="{{ route('thread.comment.store', $thread->id) }}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                              name="body"  placeholder="Your comment">{{ old('body') ? old('body'): '' }}</textarea>
                    @if ($errors->has('body'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('body') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>
    </div>
</div>
@endsection
