<?php

namespace Tests\Feature;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTopicTest extends TestCase
{
	use RefreshDatabase;

	function test_guest_can_not_create_topic()
	{
		$this->withExceptionHandling();
		$question = create('App\Question');
		$this->post('/questions/' . $question->slug . '/topics',[])
			 ->assertRedirect('/login');
	}

	function test_authenticated_user_can_create_topic()
	{
		$this->signIn();
		$question = create('App\Question');
		$this->post($question->path() . '/topics',[
			'topic' => 'test'
		]);
		$this->assertDatabaseHas('topics', [
			'topic' => 'test'
		]);

	}

	function test_topic_field_is_required()
	{
		$this->withExceptionHandling();
		$this->signIn();
		$question = create('App\Question');
		$this->post($question->path() . '/topics',[
			'topic' => null
		])->assertSessionHasErrors('topic');

	}

	function test_it_can_be_delete_by_authenticated_user()
	{
		$this->signIn();
		$question = create('App\Question');
		$this->post($question->path() . '/topics',[
			'topic' => 'test'
		]);
		$this->assertEquals(1, $question->fresh()->topics->count());
		$topic = Topic::first();

		$this->delete($question->path() . '/topics/' . $topic->topic);
		$this->assertEquals(0, $question->topics->count());
		$this->assertDatabaseMissing('topic_question', [
			'topic_id' => $topic->id,
			'question_id' => $question->id
		]);
	}

	function test_if_topic_has_been_created_just_attach_the_relational_table()
	{
		$this->signIn();
		$question1 = create('App\Question');
		$question2 = create('App\Question');

		$this->post($question1->path() . '/topics', [
			'topic' => 'topic1'
		]);
		$this->post($question2->path() . '/topics', [
			'topic' => 'topic1'
		]);

		$this->assertEquals(1, Topic::all()->count());
		$this->assertDatabaseHas('topic_question', [
			'topic_id' => 1, 'question_id' => $question1->id
		]);
		$this->assertDatabaseHas('topic_question', [
			'topic_id' => 1, 'question_id' => $question2->id
		]);

	}
}
