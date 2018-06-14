<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {

    	$activities = Activity::feed($user);
        
        if (request()->wantsJson()) {
            return response([], 204);
        }

    	return view('profile.show', [
    		'profileUser' => $user,
    		'activities' => $activities
    	]);    
    }
}
