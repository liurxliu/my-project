<div class="card">
    <div class="card-body trix-content">
        <h5 class="card-title">
        	{{ $profileUser->name }} liked the answer
        </h5> 
        <p><a href="{{ $activity->subject->likeable->path() }}">{!! $activity->subject->likeable->answer !!}</a></p>
    </div>
</div>
<br>