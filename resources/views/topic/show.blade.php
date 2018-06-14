@extends('layouts.app')


@section('content')
<div class="container">
	<h1 class="topic-title">{{ $topic->topic }}</h1>
</div>
	<hr>
<div style="margin-bottom: 100px;">
	<tabs>
		<tab name="all" :selected="true">
			<hr>
			@include('topic.all')

		</tab>
		<tab name="answer">
			<hr>
			@include('topic.answer')
		</tab>
		<tab name="others">
			<hr>
			<h3>here is other data</h3>
		</tab>
	</tabs>
</div>

@endsection