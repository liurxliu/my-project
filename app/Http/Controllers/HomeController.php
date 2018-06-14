<?php

namespace App\Http\Controllers;

use App\Filters\QuestionFilter;
use App\Question;
use App\Topic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionFilter $filter)
    {
        $questions = Question::has('answers')->with(['answers' => function ($query) {
            return $query->orderBy('likes_count', 'desc');
        }])->filter($filter)->get();

        if (request()->wantsJson()) {
            return $questions;
        }

        $topics = Topic::doesntHave('users')->get(['id', 'topic']);
        $userTopic = Topic::has('users')->get(['id', 'topic']);

        return view('home')->with([
            'questions' => $questions, 
            'topics' => $topics, 
            'userTopic' => $userTopic
        ]);
    }
}
