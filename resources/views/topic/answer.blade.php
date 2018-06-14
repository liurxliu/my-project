<div class="container">
    @foreach($topic->questions as $question)
    <div class="row">
        <div class="box">
            <button>{{ $question->answers_count }}<br>Ans</button>
            <div class="box-content">
                <h3>{{ $question->question }}</h3>
                <div class="box-body">
                    <p>
                        <img class="box-image" src="{{ asset($question->creator->avatar_path) }}">
                        <a href="{{ $question->creator->path() }}">{{ $question->creator->name }} </a>
                        <font color="#9d9d9d">{{ $question->created_at->diffForHumans() }}</font>
                    </p>
                </div>
            </div>
        </div>
        <hr>
    </div>
    @endforeach
</div>