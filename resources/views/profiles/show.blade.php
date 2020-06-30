@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card-header mb-4">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>
                @foreach($threads as $thread)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="#"> {{ $thread->creator->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
