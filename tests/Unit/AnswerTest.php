<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTest extends TestCase
{
	use RefreshDatabase;
 	function test_it_has_owner()
 	{
 		$answer = factory('App\Answer')->create();
 		$this->assertInstanceOf('App\User', $answer->owner);
 	}

 	
}
