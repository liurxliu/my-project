@extends('layouts.app')

@section('content')
@if(auth()->check())
<question :auth-check="{{ auth()->check() }}" :data="{{ $question }}" v-cloak inline-template>
@else
<question v-cloak inline-template>
@endif
    <div class="container">
        <div class="cols">
            <div class="col-6">
                <div class="question-top">
                    @if(auth()->check())
                    <topics :auth-check="{{ auth()->check() }}" :data="{{ $question->topics }}"></topics>
                    @else
                    <topics :data="{{ $question->topics }}"></topics>
                    @endif
                    <br>
                    <div class="flex">

                    <div>
                        <form action="{{ route('question.update', $question) }}" method="POST" v-if="updating">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <textarea-autosize
                                     :rows="1"
                                     :max-height="200"
                                     v-model="question"
                                     value="question"
                                     name="question"
                                     class="text"></textarea-autosize>
                            <hr>
                            <button class="btn-default" type="submit">Update</button>
                            <button class="btn-default" @click.prevent="cancel">Cancel</button>
                        </form>
                        <h1 style="margin-top: 0px;" v-else v-text="oldBody"></h1>
                    </div>

                        @can('update', $question)
                        <span class="float-right">
                            <div class="dropdown">
                                <button @click.prevent="edit = ! edit"><i class="material-icons" >
                                format_list_bulleted
                                </i></button>
                                <div class="dropdown-content" v-show="edit">
                                    <ul>
                                        <li class="edit" @click="update">Edit</li>
                                        <li class="delete" @click="remove">Delete</li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                        @endcan
                    </div>
                    <div class="question-bar">
                        <button class="question-btn" @click="OpenAnswerBox">
                            <i class="material-icons">
                                edit
                            </i>Answer
                        </button>
                        @if(auth()->check())
                        <subscribe-button :auth-check="{{ auth()->check() }}" :active="{{ json_encode($question->isSubscribed) }}"></subscribe-button>
                        @else
                            <subscribe-button :active="{{ json_encode($question->isSubscribed) }}"></subscribe-button>
                        @endif
                    </div>
                </div>
                <hr>
                @if(auth()->check())
                <answers :data="{{ $question->answers }}" :answers-count="{{ $question->answers_count }}" :auth-user="{{auth()->user()}}" 
                    :open="open" @update="open = false"></answers>
                @else
                    <answers :answers-count="{{ $question->answers_count }}" :data="{{ $question->answers }}" :auth-user="{{ 'null' }}" 
                    @deleted="answersCount--" :open="open"></answers>
                @endif
            </div>
            <div class="col-4">
                <h2>Related Questions</h2>
                <hr>
            @if(auth()->check())
                <ul>
                    @if($topics->count())
                        @foreach($topics as $topic)
                            @foreach($topic->questions as $q)
                                @if($q->question !== $question->question)
                                <li><a href="{{ $q->path() }}">{{ $q->question }}</a></li>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <p>Don't have relative topic yet. Add new one!!</p>
                    @endif
                </ul>
            @else
                <p><li><a href="#" style="color: green;" @click.prevent="show">Login</a> for more information.</li></p>
            @endif
            </div>
        </div>
    </div>
</question>
@endsection
