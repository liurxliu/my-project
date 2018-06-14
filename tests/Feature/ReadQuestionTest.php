<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadQuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->question = create('App\Question');
    }

    function test_user_can_visit_all_questions()
    {
        $response = $this->get('/questions');
        $response->assertSee($this->question->question);
        
    }
    function test_user_can_visit_a_question()
    {
    	$this->getJson('/questions/' . $this->question->slug)
             ->assertSee($this->question->question);
    }

    function test_user_can_see_the_answer()
    {
    	$answer = create('App\Answer', ['question_id' => $this->question->id]);
    	$this->get('/questions/' . $this->question->slug)
    	     ->assertSee($answer->answer);
    }

    function test_it_records_times_when_user_visit_the_page()
    {
        $this->assertSame(0, $this->question->visits);
        $this->call('GET', $this->question->path());
        $this->assertEquals(1, $this->question->fresh()->visits);
    }

}
