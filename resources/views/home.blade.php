@extends('layouts.app')

@section('content')
<home inline-template>
    <div class="container">
        <div class="rows">
            <div class="col-left">
                <div class="sidebar-left">
                    <a href="/" :class="{'selected': currentPath === '/'}">
                        <i class="material-icons">import_contacts</i>
                        <span>Newest</span>
                    </a>
                    <a href="/?popularity=1" :class="{'selected': currentPath === '/?popularity=1'}">
                        <i class="material-icons">whatshot</i>
                        <span>Top issues</span>
                    </a>
                    @if(auth()->check())
                        <a href="/?recommand=1" :class="{'selected': currentPath === '/?recommand=1'}">
                            <i class="material-icons">thumb_up_alt</i>
                            <span>Recommand</span>
                        </a>
                    @else
                        <a href="/login" @click.prevent="show">
                            <i class="material-icons">thumb_up_alt</i>
                            <span>Recommand</span>
                        </a>
                    @endif
                    <a href="/?all=1" :class="{'selected': currentPath === '/?all=1'}">
                        <i class="material-icons">turned_in</i>
                        <span>All</span>
                    </a>
                </div>
            </div>
            <div class="col-md"> 
                @if (auth()->check())
                    <ask-question></ask-question>
                    <br>
                @endif
                @foreach ($questions as $question)
                    <div class="card">
                        <div class="card-body trix-content">
                            <h4 class="card-title">
                                <a href="{{ $question->path() }}">
                                    @if(auth()->check())
                                        @if($question->hasUpdated(auth()->user()))
                                            <strong>{{ $question->question }}</strong>
                                        @else
                                            {{ $question->question }}
                                        @endif
                                    @else
                                        {{ $question->question }}
                                    @endif
                                </a>
                                <br>
                                <span class="span-text">
                                    <a href="{{ $question->path() }}"> 
                                        {{ $question->answers_count }}
                                        {{ str_plural('answer', $question->answers_count) }}
                                    </a>
                                </span>
                            </h4>
                            
                            <img class="home-image" src="{{ asset($question->creator->avatar_path) }}">
                            <p>
                                <span><a href="{{ $question->creator->path() }}">{{ $question->creator->name }}</a></span><br>
                                <font color="#9d9d9d">{{ $question->created_at->diffForHumans() }}</font>
                            <p>
                            <p class="card-text">{!!  $question->answers->first()->answer !!}</p> 
                        </div>
                    <br>
                </div>
                @endforeach
            </div>
            <div class="col-right">
                @if(auth()->check())
                    <topic-filter :topics="{{ $topics }}" :user="{{ auth()->user() }}"></topic-filter>
                    <div class="card">
                        <div class="card-header">
                            Your topics<i class="material-icons" style="float: right;position: relative;bottom: 3px;" @click="editTopic">edit</i>
                        </div>
                        <div class="card-body">
                            <ul>
                                <user-topics :topics="{{ $userTopic }}" :editing="editing" :user="{{ auth()->user() }}"></user-topics>
                            </ul>
                        </div>
                    </div>
                @else
                    <p><li><a href="#" style="color: green;" @click.prevent="show">Login</a> for more information.</li></p>
                @endif
            </div>
        </div>
    </div>
</home>
@endsection
