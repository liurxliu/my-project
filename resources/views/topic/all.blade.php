<div class="container">
	<div class="rows">
		<div class="col-6"> 
		    @foreach ($topic->questions as $question)
		        <div class="card">
		            <div class="card-body trix-content">
		                <h4 class="card-title ">
		                    <a href="{{ $question->path() }}">
		                        @if($question->hasUpdated(auth()->user()))
		                            <strong>{{ $question->question }}</strong>
		                        @else
		                            {{ $question->question }}
		                        @endif
		                    </a>
		                </h4>     
		                <img class="home-image" src="{{ asset($question->creator->avatar_path) }}">
		                <p>
		                    <span>{{ $question->creator->name }}</span><br>
		                    <font color="#9d9d9d">{{ $question->created_at->diffForHumans() }}</font>
		                </p>
		                <p class="card-text">{!!  $question->answers->first()->answer !!}</p> 
		            </div>
		        <br>
		    </div>
		    @endforeach
		</div>
		<div class="col-4">
            <div class="card">
                may has ad here ...
            </div>
        </div>
	</div>
</div>