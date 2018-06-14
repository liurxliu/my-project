<?php

namespace Oauth\User;

class GoogleUser
{
	protected $userInfo = [];

	public function __construct($userInfo)
	{
		$this->userInfo = $userInfo;
	}

	public function getName()
	{
		return $this->userInfo['displayName'];
	}

	public function getEmail()
	{
		return $this->userInfo['emails'][0]['value'];
	}

	public function getPhotoUrl()
	{
		return $this->userInfo['image']['url'];
	}
}