<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestion;
use App\Question;


class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    public function index()
    {
    	$questions = Question::latest()->get();
    	return view('question.index')->with('questions', $questions);
    }

    public function show($question)
    {
        $question = Question::where('slug', $question)
                    ->with(['topics:id,topic', 'answers' => $this->orderBy('likes_count')])
                    ->first();

        // cache the user who visited the question
        cache()->forever($question->getCacheKey(), \Carbon\Carbon::now());

        $question->increment('visits');
        // for relative questions.
        $topics = $question->topics()->with(['questions' => $this->orderBy('answers_count', 20)
        ])->get();

        if (request()->wantsJson()) {
            return $question->toJson();
        }

    	return view('question.show')->with(['question' => $question, 'topics' => $topics]);
    }

    public function store(CreateQuestion $request)
    {
    	$question = Question::create([
    		'user_id' => auth()->id(),
    		'question' => $request->question,
            'slug' => str_slug($request->question)
    	]);

    	return response(['redirect' => $question->path()]);
    }

    public function destroy(Question $question)
    {
        $this->authorize('update', $question);

        $question->delete();
        
        if (request()->wantsJson()) {
            return response([], 204);
        }
        
        return redirect('/')->with('flash', 'Delete question.');
    }

    public function update(CreateQuestion $request, Question $question)
    {
        $this->authorize('update', $question);
        $question->update(['question' => $request->question, 'slug' => str_slug($request->question)]);
        return redirect($question->path());
    }

    public function orderBy($field, $limit = 100, $pattern = 'desc')
    {
        return function($query) use ($field, $pattern, $limit) {
            return $query->orderBy($field, $pattern)->limit($limit);
        };
    }
}
