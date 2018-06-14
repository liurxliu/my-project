<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    function test_topic_can_have_many_questions()
    {
    	$this->signIn();
    	$question = create('App\Question');
    	$this->post($question->path() . '/topics', [
    		'question_id' => $question->id,
    		'topic' => 'test'
    	]);
    	$this->assertEquals(1, $question->topics->count());
    	$this->post($question->path() . '/topics', [
    		'question_id' => $question->id,
    		'topic' => 'testagain'
    	]);
    	$this->assertEquals(2, $question->fresh()->topics->count());

    }
}
