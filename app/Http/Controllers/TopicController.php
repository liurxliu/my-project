<?php

namespace App\Http\Controllers;

use App\Question;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->except('index', 'show');
	}

    public function index()
    {
        $topics = Topic::orderBy('topic')->get()->groupBy(function($topic) {
            return strtoupper(substr($topic->topic, 0, 1));
        });

        return view('topic.index')->with('topics', $topics);
    }

    public function show(Topic $topic)
    {
        return view('topic.show')->with('topic', $topic);
    }

    public function store(Question $question)
    {
    	request()->validate(['topic' => 'required']);

        if( ! Topic::where('topic', request()->topic)->exists()) {
            $topic = Topic::create([
                'topic' => request()->topic
            ]);
        }
        $topic = Topic::where('topic', request()->topic)->first();
    	
        $question->topics()->attach($topic->id);

        return back();
    }

    public function destroy(Question $question, Topic $topic)
    {
        $question->topics()->delete();
        $question->topics()->detach($topic->id);
    }
}
