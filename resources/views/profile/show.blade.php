@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            @if(auth()->check())
        	   <avatar-form :auth-check="{{ auth()->check() }}" :profile-user="{{ $profileUser }}"></avatar-form>
            @else
                <avatar-form :profile-user="{{ $profileUser }}"></avatar-form>
            @endif

        	@foreach($activities as $date => $activity)
                <h3>{{ $date }}</h3>
                <hr>
                @foreach ($activity as $record)
                   @if(view()->exists("profile.activity.{$record->type}"))
        	           @include("profile.activity.{$record->type}", ['activity' => $record])
                   @endif
                @endforeach
            @endforeach
        </div>
    </div>
</div>

@endsection