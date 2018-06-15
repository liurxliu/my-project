<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic', 'topic_user')->withTimestamps();
    }

    public function path()
    {
        return "/profile/{$this->name}";
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function createSocial($socialUser)
    {
        $hasUser = self::where('email', $socialUser->getEmail())->first();
        if($hasUser) {
            \Auth::login($hasUser);

            return redirect('/');
        } else {
            $this->name = $socialUser->getName();
            $this->password = bcrypt(str_random(40));
            $this->email = $socialUser->getEmail();
            $this->avatar_path = $socialUser->getPhotoUrl();
            $this->save();
            \Auth::login($this);
            return redirect()->route('home');
        }
    }
}
