<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTopicTest extends TestCase
{
    use RefreshDatabase;

    function test_un_authenticated_user_can_not_add_favorite_topics()
    {
    	$this->withExceptionHandling();
    	$this->post("/leo/topics", [
            'ids' => 1
        ])->assertRedirect('/login');
    }

    function test_a_authenticated_user_can_add_favorite_topics()
    {
    	$this->signIn();
    	$topic = create('App\Topic');
        $topic2 = create('App\Topic');
    	$user = auth()->user();
    	$this->post("/{$user->name}/topics", [
            'ids' => [$topic->id, $topic2->id]
        ]);
    	$this->assertDatabaseHas('topic_user', [
    		'user_id' => auth()->id(),
    		'topic_id' => $topic->id
    	]);
        $this->assertDatabaseHas('topic_user', [
            'user_id' => auth()->id(),
            'topic_id' => $topic2->id
        ]);
    }

    function test_user_can_delete_favorite_topics()
    {
        $this->signIn();
        $topic = create('App\Topic');
        $topic2 = create('App\Topic');
        $user = auth()->user();
        $this->post("/{$user->name}/topics", [
            'ids' => [$topic->id, $topic2->id]
        ]);
        $this->assertEquals(2, auth()->user()->topics()->count());  
        $this->delete("/{$user->name}/topics/{$topic->topic}");
        $this->assertEquals(1, auth()->user()->topics()->count());
    }
}
