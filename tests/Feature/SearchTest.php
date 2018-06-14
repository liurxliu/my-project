<?php

namespace Tests\Feature;

use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    function test_questions_can_be_searched()
    {
    	config(['scout.driver' => 'algolia']);
    	$search = 'foobar';
    	create('App\Question', ['question' => 'test'], 2);
    	create('App\Question', ['question' => "a question with {$search}"], 2);
    	

    	do{
    		sleep(.25);
    		$results = $this->getJson("/search?q={$search}")->json()['data'];
    	} while(empty($results));

    	$this->assertCount(2, $results);
    	Question::latest()->take(4)->unsearchable();
    }
}
