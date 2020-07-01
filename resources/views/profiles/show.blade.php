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
                @foreach($activities as $date => $activity)
                    <div class="card-header">
                        <h3>{{ $date }}</h3>
                    </div>
                    @foreach($activity as $record)
                        @include("profiles.activities.{$record->type}" , ['activity' => $record])
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
