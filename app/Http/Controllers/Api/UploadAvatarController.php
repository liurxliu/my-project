<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadAvatarController extends Controller
{
    public function store(Request $request, $user)
    {
    	$this->validate($request, [
    		'avatar' => ['required', 'image']
    	]);
        $pathName = \Storage::disk('s3')->put('avatar', $request->file('avatar'), 'public');
    	auth()->user()->update([
    		'avatar_path' => \Storage::disk('s3')->url($pathName)
    	]);

    	return back();
    }
}
