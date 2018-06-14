@extends('layouts.app')

@section('content')
<div class="container">
	<div class="topic-col">
		@foreach ($topics as $tag => $values)
			<div class="col">
				<h1>{{ $tag }}</h1>
				<hr>
				@foreach ($values as $value)
					<ul>
						<li>
							<a href="/topics/{{ $value->topic }}">
								{{ $value->topic }}
							</a>		
						</li>
					</ul>
					
				@endforeach
			</div>
		@endforeach
	</div>
</div>
	

@endsection