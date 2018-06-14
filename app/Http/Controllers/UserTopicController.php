<?php

namespace App\Http\Controllers;

use App\Topic;
use App\User;
use Illuminate\Http\Request;

class UserTopicController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function store(User $user)
    {
    	$user->topics()->attach(request('ids'));
    }

    public function destroy(User $user, Topic $topic)
    {
    	$user->topics()->detach($topic->id);
    }
}
