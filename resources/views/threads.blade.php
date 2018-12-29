@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.partials.alerts')

    <div class="row mt-3">
        <div class="col-sm-3">
            @if ($users_filter->count())
                <div class="card mb-3">
                    <div class="card-header">Authors </div>
                    <div class="card-body">
                        @foreach($users_filter as $user)
                            <form method="POST" action="{{ route('threads.user.filter.forget') }}" class="mb-3">
                                @csrf
                                <span class="badge badge-info">{{ $user->name }}
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">Author Filter</div>
                <div class="card-body">
                    <p>Add a user from list below to filter the threads</p>
                    <form method="POST" action="{{ route('threads.user.filter.push') }}">
                        @csrf
                        @if ($errors->has('user_id'))
                            <div class="alert alert-danger">{{ $errors->first('user_id') }}</div>
                        @endif
                        <div class="input-group input-group-sm">
                            <select class="form-control auto-complete" name="user_id" >
                                <option value="">-- Select a user --</option>
                                @foreach ($authors as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->id }} - {{ $user->name }} - {{$user->email}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">Add to filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card mb-3">
                <div class="card-header">Threads</div>
                <div class="card-body">
                    @if ($threads->count())
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Title {!!   request('orderBy') === 'title'?'': '<a href="'.route('threads').'?orderBy=title&orderType=asc"><i class="fas fa-angle-down"></i></a>' !!}</th>
                                <th scope="col">Content {!!   request('orderBy') === 'body'?'': '<a href="'.route('threads').'?orderBy=body&orderType=asc"><i class="fas fa-angle-down"></i></a>' !!}</th>
                                <th scope="col">date {!!   request('orderBy') === 'created_at'?'': '<a href="'.route('threads').'?orderBy=created_at&orderType=desc"><i class="fas fa-angle-down"></i></a>' !!}</th>
                                <th scope="col">Author {!!   request('orderBy') === 'user_id'?'': '<a href="'.route('threads').'?orderBy=user_id&orderType=asc"><i class="fas fa-angle-down"></i></a>' !!}</th>
                                @if (auth()->user()->isAdmin())
                                    <th scope="col">Delete</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($threads as $thread)
                                <tr>
                                    <td><a href="{{ route('thread', $thread->id) }}">{{ $thread->title }}</a></td>
                                    <td>{{ str_limit($thread->body , 75, '...') }}</td>
                                    <td>{{ $thread->created_at->diffForHumans() }}</td>
                                    <td>{{ $thread->user->name }}</td>
                                    @if (auth()->user()->isAdmin())
                                        <td align="center">
                                            <a href="{{ route('thread.destroy', $thread->id) }}" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#deleteConfirm">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    @endif
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
    <div>
</div>
@endsection
