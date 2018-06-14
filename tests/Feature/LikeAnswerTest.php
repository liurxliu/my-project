<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeAnswerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->answer = create('App\Answer');
    }

    function test_guest_cannot_like_answer()
    {
        $this->withExceptionHandling();
    	$this->post('/answers/' . $this->answer->id . '/likes')
    		->assertRedirect('/login');

    }

    function test_an_authenticated_user_can_like_answer()
    {
    	$this->signIn();
    	$this->post('/answers/' . $this->answer->id . '/likes');
    	$this->assertEquals(1, $this->answer->fresh()->likes_count);
    }

    function test_an_authenticated_user_can_like_answer_once()
    {
    	$this->withoutExceptionHandling();
    	$this->signIn();

    	$this->post('/answers/' . $this->answer->id . '/likes');
    	$this->post('/answers/' . $this->answer->id . '/likes');
    	$this->assertCount(1, $this->answer->likes);
    }

    function test_an_authenticated_user_can_unlike_answer()
    {
        $this->signIn();
     
        $this->post('/answers/' . $this->answer->id . '/likes');
        $this->assertEquals(1, $this->answer->fresh()->likes_count);

        $this->delete('/answers/' . $this->answer->id . '/likes');
        $this->assertEquals(0, $this->answer->fresh()->likes_count);
    }

}
