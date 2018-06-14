@extends('layouts.app')

@section('content')
<!-- <div class="container"> -->
<ais-index
	app-id="{{ config('scout.algolia.id') }}"
	api-key="{{ config('scout.algolia.key') }}"
	index-name="questions"
	query="{{ request('q') }}">
	<div class="search-bar">
		<ais-search-box >
			<ais-input placeholder="Search for question ..." :autofocus="true" class="search-input"></ais-input>
		</ais-search-box>
	</div>
    <div class="container">
    	<div class="rows">
	        <div class="col-6">
	          	<ais-results>
	          		<template slot-scope="{ result }">
	          			<div class="search-result">
		          			<li>
		          				<a :href="result.path">
		          					<ais-highlight :result="result" attribute-name="question"></ais-highlight>
		          				</a>
		          			</li>
		          		</div>
	          		</template>
	          	</ais-results>
	        </div>
	        <div class="col-4">
	        	<div class="card">
	        		<div class="card-header">
	        			<h3>Search by topics</h3>
	        		</div>
	        		<div class="card-body">
	        			<ais-refinement-list attribute-name="topics.topic"></ais-refinement-list>
	        		</div>
	        		
	        	</div>
	        	
	        </div>
	    </div>
    </div>
</ais-index>
<!-- </div> -->

@endsection