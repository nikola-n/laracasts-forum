@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card-header mb-4">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>
                @forelse($activities as $date => $activity)
                    <div class="card-header">
                        <h3>{{ $date }}</h3>
                    </div>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}" , ['activity' => $record])
                        @endif
                    @endforeach
                    @empty
                    <p> There is no activity for this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
