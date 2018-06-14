<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    function test_when_a_question_is_created_a_activity_is_recorded()
    {
    	$this->signIn();
    	$question = create('App\Question');
    	$this->assertDatabaseHas('activities', [
    		'user_id' => auth()->id(),
    		'subject_id' => $question->id,
    		'subject_type' => 'App\Question',
    		'type' => 'created_question'
    	]);
    	$activity = \App\Activity::first();
    	$this->assertEquals($activity->subject->id, $question->id);
    }

    function test_when_a_answer_id_created_a_activity_is_recorded()
    {
    	$this->signIn();
    	$answer = create('App\Answer');
    	$this->assertEquals(2, \App\Activity::count());
    }

    function test_it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        create('App\Question', ['user_id' => auth()->id()], 2);

        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user());
        
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));

    }
}
