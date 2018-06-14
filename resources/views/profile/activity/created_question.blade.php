<div class="card">
    <div class="card-body">
        <h5 class="card-title">
        	{{ $profileUser->name }} asked: 
        	<a href="{{ $activity->subject->path() }}">{{ $activity->subject->question }}</a>
        </h5>
    </div>
</div>
<br>