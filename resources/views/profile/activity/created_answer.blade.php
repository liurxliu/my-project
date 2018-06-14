<div class="card">
    <div class="card-body trix-content">
        <h5 class="card-title">
        	{{ $profileUser->name }} answered:
        	<a href="{{ $activity->subject->question->path() }}">
        		{{ $activity->subject->question->question }}
        	</a>
        </h5> 
        <p>{!! $activity->subject->answer !!}</p>
    </div>
</div>
<br>