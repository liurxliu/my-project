<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
    	$search = request('q');
    	$questions = Question::search($search)->paginate(25);
    	if (request()->expectsJson()) {
    		return $questions;
    	}
    	return view('search')->with('questions', $questions);
    }
}
