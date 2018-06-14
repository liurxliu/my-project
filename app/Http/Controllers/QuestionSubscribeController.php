<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionSubscribeController extends Controller
{
    public function store(Question $question)
    {
    	$question->subscribe();
    }

    public function destroy(Question $question)
    {
    	$question->unsubscribe();
    }
}
