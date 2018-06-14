<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToQuestionTest extends TestCase
{
    use RefreshDatabase;

    function test_an_authenticated_user_can_subscribe()
    {
    	$this->signIn();

    	$question = create('App\Question');
    	$this->post($question->path() . '/subscribe');
    	$question->AnswerQuestion([
    		'user_id' => auth()->id(),
    		'answer' => 'some answers'
    	]);
    	$this->assertEquals(0, auth()->user()->notifications()->count());
    	$question->AnswerQuestion([
    		'user_id' => create('App\User')->id,
    		'answer' => 'some answers'
    	]);
    	
    	$this->assertEquals(1, auth()->user()->notifications()->count());

    	
    }

    function test_an_authenticated_user_can_unsubscribe()
    {
    	$this->signIn();
    	$question = create('App\Question');
    	$this->post($question->path() . '/subscribe');
    	$this->assertEquals(1, $question->subscriptions()->count());
    	$this->delete($question->path() . '/subscribe');
    	$this->assertEquals(0, $question->subscriptions()->count());
    }
}
