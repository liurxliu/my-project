<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    function test_user_can_visit_profile()
    {
    	$user = create('App\User');
    	$this->get('/profile/' . $user->name)
    		 ->assertSee($user->name);
    }

    function test_user_can_see_question_activity_if_a_question_is_created()
    {
        $this->signIn();
        $question = create('App\Question');
        $this->get('/profile/' . auth()->user()->name)
             ->assertSee($question->question);
    }

    function test_user_can_see_answer_activity_if_a_answer_is_created()
    {
        $this->signIn();
        $question = create('App\Question');
        $answer = create('App\Answer', ['question_id' => $question->id]);
        $this->get('/profile/' . auth()->user()->name)
             ->assertSee($answer->answer);
    }

    function test_user_can_see_like_activity_if_a_like_is_created()
    {
        $this->signIn();
        $question = create('App\Question');
        $answer = create('App\Answer', ['question_id' => $question->id]);
        $like = create('App\Like', [
            'user_id' => auth()->id(), 'likeable_id' => $answer->id
        ]);
        $this->get('/profile/' . auth()->user()->name)
             ->assertSee(auth()->user()->name . ' liked the answer');
    }
}
