<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\CreateAnswer;
use App\Question;


class AnswerController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function store(CreateAnswer $request, Question $question)
    {
    	$answer = $question->AnswerQuestion([
    		'user_id' => auth()->id(),
    		'answer' => $request->answer,
    	]);

        if(request()->wantsJson()) {
            return response($answer->load('owner'));
        }

    	return back()->with('flash', "You answered the question.");
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->delete();

        if(request()->wantsJson()) {
            return response(['deleted']);
        }
        return back()->with('flash', 'Delete answer.');
    }
    public function update(Answer $answer)
    {
        $this->authorize('update', $answer);

        request()->validate([
            'answer' => 'required'
        ]);

        $answer->update(request(['answer']));
        return redirect($answer->path());
    }
}
