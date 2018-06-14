<?php

namespace Tests\Unit;

use App\Notifications\UpdateQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
	use RefreshDatabase;
    function test_it_has_creator()
    {
    	$question = factory('App\Question')->create();
    	$this->assertInstanceOf('App\User', $question->creator);
    }

    function test_it_can_create_answers()
    {
    	$question = factory('App\Question')->create();
    	$question->AnswerQuestion([
    		'answer' => 'foobar',
    		'user_id' => 1
    	]);
    	$this->assertCount(1, $question->answers);
    }

    function test_it_can_be_subscribe()
    {
        $question = create('App\Question');
        $question->subscribe($userId = 1);
        $this->assertEquals(1, $question->subscriptions()->count());
    }

    function test_it_can_unsubscribe()
    {
        $question = create('App\Question');
        $question->subscribe($userId = 1);
        $question->unsubscribe($userId);
        $this->assertEquals(0, $question->subscriptions()->count());

    }

    function test_it_know_if_it_is_subscribed()
    {
        $this->signIn();
        $question = create('App\Question');
        $question->subscribe(auth()->id());
        $this->assertTrue($question->isSubscribed);
    }

    function test_it_notifies_all_subscribers_when_a_new_answer_is_created()
    {
        \Notification::fake();

        $this->signIn();
        $question = create('App\Question')
                    ->subscribe()
                    ->AnswerQuestion([
                        'answer' => 'something',
                        'user_id' => 999
                    ]);
        \Notification::assertSentTo(auth()->user(), UpdateQuestion::class);
    }

    function test_when_a_new_answer_is_created_update_timestamp_of_question()
    {
        $question = create('App\Question');
        $question->AnswerQuestion([
            'answer' => 'something',
            'user_id' => 999
        ]);

        $this->assertEquals(
            date_format(\Carbon\Carbon::now(), 'Y-m-d H:i'), 
            date_format($question->updated_at, 'Y-m-d H:i')
        );

    }

    function test_it_can_check_if_the_user_see_all_the_new_answer()
    {
        $this->signIn();
        $question = create('App\Question');
        $this->assertTrue($question->hasUpdated(auth()->user()));
        $key = sprintf("user.%s.visits.%s", auth()->id(), $question->id);
        cache()->forever($key, \Carbon\Carbon::now());
        $this->assertFalse($question->hasUpdated(auth()->user()));
    }

    function test_it_know_if_it_has_topic()
    {
        $this->withExceptionHandling();
        $question = create('App\Question');
        $topic = create('App\Topic');
        $question->topics()->attach($topic->id);
        $this->assertTrue($question->hasTopic($topic->topic));
    }

}
