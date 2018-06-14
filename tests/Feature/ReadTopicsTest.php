<?php

namespace Tests\Feature;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadTopicsTest extends TestCase
{
	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();
		$this->topic = create('App\Topic');
	}

	function test_user_can_see_all_topics()
	{
		$this->get('/topics')
			 ->assertSee($this->topic->topic);
	}

	function test_user_can_see_one_topic()
	{
		$this->get("/topics/" . $this->topic->topic)
			 ->assertSee($this->topic->topic);
	}
}
