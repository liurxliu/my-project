<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	use RecordActivity;
    protected $guarded = [];
    protected $with = ['likeable:id,answer'];
    public function likeable()
    {
    	return $this->morphTo();
    }
    
}
