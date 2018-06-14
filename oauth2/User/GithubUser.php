<?php

namespace Oauth\User;

class GithubUser
{
	protected $userInfo = [];

	public function __construct($userInfo)
	{
		$this->userInfo = $userInfo;
	}

	public function getName()
	{
		return $this->userInfo['name'];
	}

	public function getEmail()
	{
		return $this->userInfo['email'];
	}

	public function getPhotoUrl()
	{
		return $this->userInfo['avatar_url'];
	}
}