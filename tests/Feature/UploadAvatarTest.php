<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadAvatarTest extends TestCase
{
	use RefreshDatabase;

	function test_a_guest_cannot_upload_avatar()
	{
		$this->withExceptionHandling();
		$response = $this->json('POST', '/api/users/1/avatar');
		$response->assertStatus(401);
	}

	function test_a_valid_format_should_be_provided()
	{
		$this->signIn()->withExceptionHandling();
		$response = $this->json('POST', '/api/users/'. auth()->id() .'/avatar', [
			'avatar' => 'default avatar'
		]);
		$response->assertStatus(422);
	}

	function test_a_user_can_add_avatar_to_their_profile()
	{
		$this->signIn();
		Storage::fake('s3');
		$response = $this->json('POST', '/api/users/'. auth()->id() .'/avatar', [
			'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
		]);
		Storage::disk('s3')->assertExists('/avatar/' . $file->hashName());
		$this->assertEquals('/storage/avatar/' . $file->hashName(), auth()->user()->avatar_path);
	}
}
