<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateQuestionTest extends TestCase
{
    use RefreshDatabase;
    function test_guest_cannot_create_question()
    {
        $this->withExceptionHandling();
    	$this->post('/questions', [])
    		->assertRedirect('/login');
    }
    function test_an_authenticated_user_can_create_question()
    {
        $this->withoutExceptionHandling();
    	$this->signIn();
    	$question = make('App\Question');
    	$this->post('/questions', $question->toArray());
    	$this->get($question->path())
    		 ->assertSee($question->question);
    }

    function test_it_requires_question()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $question = make('App\Question', ['question' => null]);
        $this->post('/questions', $question->toArray())
             ->assertSessionHasErrors('question');
    }

    function test_unauthorized_user_can_not_delete_question()
    {
        $this->withExceptionHandling();
        $question = create('App\Question');
        // guest
        $this->delete($question->path())->assertRedirect('/login');
        $this->signIn();

        $this->delete($question->path())->assertStatus(403);
    }


    function test_authorized_user_can_delete_question()
    {
        $this->signIn();

        $question = create('App\Question', ['user_id' => auth()->id()]);
        $answer = create('App\Answer', ['question_id' => $question->id]);

        $response = $this->json('DELETE', $question->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
        $this->assertEquals(0, \App\Activity::count());
    }

    function test_authorized_user_can_update_question()
    {
        $this->signIn();
        $question = create('App\Question', ['user_id' => auth()->id()]);

        $this->patch($question->path(), ['question' => 'has changed']);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question' => 'has changed',
            'slug' => 'has-changed'
        ]);
            
    }

    function test_unauthorized_user_can_not_delete_answer()
    {
        $this->withExceptionHandling();
        $answer = create('App\Answer');
        $this->delete('/answers/' . $answer->id)
            ->assertRedirect('/login');
        $this->signIn();
        $this->delete('/answers/' . $answer->id)
            ->assertStatus(403);
    }

    function test_authorized_user_can_delete_answer()
    {
        $this->signIn();
        $answer = create('App\Answer', ['user_id' => auth()->id()]);

        $this->post('/answers/' . $answer->id . '/likes');
        $this->delete('/answers/' . $answer->id);

        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
        $this->assertDatabaseMissing('likes', ['id' => 1]);
    }

     function test_unauthorized_user_can_not_update_answer()
    {
        $this->withExceptionHandling();
        $answer = create('App\Answer');
        $this->patch('/answers/' . $answer->id, ['answer' => 'changed'])
            ->assertRedirect('/login');
        $this->signIn();
        $this->patch('/answers/' . $answer->id, ['answer' => 'changed'])
            ->assertStatus(403);
    }

    function test_authorized_user_can_update_answer()
    {
        $this->signIn();
        $answer = create('App\Answer', ['user_id' => auth()->id()]);
        $this->patch('/answers/' . $answer->id, ['answer' => 'changed']);
        $this->assertDatabaseHas('answers', ['id' => auth()->id(), 'answer' => 'changed']);

    }
}
