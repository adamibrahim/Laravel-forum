@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.partials.alerts')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Write a Thread</div>
                <div class="card-body">
                   <form method="POST" action="{{ route('thread.store') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                            name="title"  placeholder="Title" value="{{ old('title') ? old('title'): '' }}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                            name="body"  placeholder="Content">{{ old('body') ? old('body'): '' }}</textarea>
                            @if ($errors->has('body'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Post Thread</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">Your Threads</div>
                <div class="card-body">
                    @if ($threads->count())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">date</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($threads as $thread)
                                <tr>
                                    <th scope="row">{{ $thread->id }}</th>
                                    <td><a href="{{ route('thread', $thread->id) }}">{{ $thread->title }}</a></td>
                                    <td>{{ str_limit($thread->body , 75, '...') }}</td>
                                    <td>{{ $thread->created_at->diffForHumans() }}</td>
                                    <td align="center">
                                        <a href="{{ route('thread.destroy', $thread->id) }}" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#deleteConfirm">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            <p>You have not posted any thread yet !</p>
                        </div>
                    @endif
                    <!-- Modal -->
                    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure !?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="#" class="btn btn-danger delete-confirm">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


