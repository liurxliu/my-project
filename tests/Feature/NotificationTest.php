<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    function test_it_prepared_when_a_question_is_answerd()
    {
    	$this->signIn();
    	$question = create('App\Question')->subscribe();
    	$question->AnswerQuestion([
    		'user_id' => auth()->id(),
    		'answer' => 'something'
    	]);
    	$this->assertEquals(0, auth()->user()->notifications()->count());
    	$question->AnswerQuestion([
    		'user_id' => create('App\User')->id,
    		'answer' => 'something'
    	]);
    	$this->assertEquals(1, auth()->user()->notifications()->count());

    }

    function test_user_can_remove_notification()
    {
    	$this->signIn();

    	$question = create('App\Question')->subscribe();
    	
    	$question->AnswerQuestion([
    		'user_id' => create('App\User')->id,
    		'answer' => 'something'
    	]);

    	$notificationId = auth()->user()->unreadNotifications()->first()->id;
    	$name = auth()->user()->name;
    	$this->delete("/profile/{$name}/notifications/{$notificationId}");
    	$this->assertEquals(0, auth()->user()->unreadNotifications()->count());
    }

    function test_user_can_see_unread_notifications()
    {
    	$this->signIn();

    	$question = create('App\Question')->subscribe();
    	
    	$question->AnswerQuestion([
    		'user_id' => create('App\User')->id,
    		'answer' => 'something'
    	]);

    	$notificationId = auth()->user()->unreadNotifications()->first()->id;
    	$name = auth()->user()->name;

    	$response = $this->getJson("/profile/{$name}/notifications")->json();

    	$this->assertEquals(1, count($response));
    }
}
