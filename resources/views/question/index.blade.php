@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($questions as $question)
    <div class="row">
        <div class="box">
            <button>{{ $question->answers_count }}<br>Ans</button>
            <div class="box-content">
                <h3><a href="{{ $question->path() }}">{{ $question->question }}</a></h3>
                <div class="box-body">
                    <p>
                        <img class="box-image" src="{{ asset($question->creator->avatar_path) }}">
                        <a style="color: #00a600;" href="{{ $question->creator->path() }}">{{ $question->creator->name }} </a>
                        <font color="#9d9d9d">{{ $question->created_at->diffForHumans() }}</font>
                    </p>
                </div>
            </div>
        </div>
        <hr>
    </div>
    @endforeach
</div>
@endsection
