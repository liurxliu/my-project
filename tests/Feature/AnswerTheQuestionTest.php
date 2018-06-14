<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTheQuestionTest extends TestCase
{
    use RefreshDatabase;

    function test_unauthenticated_user_cannot_answer_the_question()
    {
        $this->withExceptionHandling();
        $this->post('/questions/1/answer', [])
             ->assertRedirect('/login');
        
    }

    function test_an_anthenticated_user_can_answer_the_question()
    {   
        // $this->withoutExceptionHandling();
    	$this->signIn();
    	$question = create('App\Question');
    	$answer = make('App\Answer');
    	$this->post('/questions/' . $question->slug . '/answer', $answer->toArray());
    	$this->get($question->path())
    		->assertSee($answer->answer);
        $this->assertEquals(1, $question->fresh()->answers_count);
    }

    function test_it_requires_answer_field()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $question = create('App\Question');
        $answer = make('App\Answer', ['answer' => null]);
        $this->post($question->path() . '/answer', $answer->toArray())
            ->assertSessionHasErrors('answer');

    }
}
