<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Like;
use Illuminate\Http\Request;


class LikeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function store(Answer $answer)
    {
    	$answer->like();
 
    	return back();
    }

    public function destroy(Answer $answer) {
    	$answer->unlike();
    	if(request()->wantsJson()) {
    		return response(['delete like']);
    	}
    	return back();
    }
}
