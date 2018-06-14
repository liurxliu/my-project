<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterQuestionTest extends TestCase
{
    use RefreshDatabase;

    function test_questions_can_be_filtered_by_popularity()
    {
    	$questionWithOneAnswer = create('App\Question');
    	create('App\Answer', ['question_id' => $questionWithOneAnswer->id]);

    	$questionWithTwoAnswers = create('App\Question');
    	create('App\Answer', ['question_id' => $questionWithTwoAnswers->id], 2);

    	$questionWithThreeAnswers = create('App\Question');
    	create('App\Answer', ['question_id' => $questionWithThreeAnswers->id], 3);

    	$response = $this->getJson('/?popularity=1')->json();

    	$this->assertEquals([3, 2, 1], array_column($response, 'answers_count'));
    }

    function test_questions_can_be_filtered_by_users_favorite_topics()
    {
        $this->signIn();
        // create questions with answer
        $question = create('App\Question');
        $answer = create('App\Answer', ['question_id' => $question->id]);

        $question2 = create('App\Question');
        $answer2 = create('App\Answer', ['question_id' => $question2->id]);
        // create topics
        $topicPhp = create('App\Topic', ['topic' => 'PHP']);
        $topicGolang = create('App\Topic', ['topic' => 'Golang']);
        // question add topic
        $this->post($question->path() . '/topics', [
            'topic' => 'PHP'
        ]);
        $this->post($question->path() . '/topics', [
            'topic' => 'Golang'
        ]);
        // user add favorite topics
        $this->post('/' . auth()->user()->name . '/topics', [
            'ids' => [$topicPhp->id, $topicGolang->id]
        ]);
        // see question with topic php and golang.
        $response = $this->getJson('/?recommand=1')->json();
        $questions = array_column($response, 'question');
        $this->assertContains($question->question, $questions);
        $this->assertNotContains($question2->question, $questions);
    }
}
