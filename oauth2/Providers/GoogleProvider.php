<?php

namespace Oauth\Providers;


use Oauth\Providers\AbstractProvider;


class GoogleProvider extends AbstractProvider
{
	public function BaseAuthUrl()
	{
		return "https://accounts.google.com/o/oauth2/auth?";
	}

	public function baseAccessTokenUrl()
	{
		return "https://www.googleapis.com/oauth2/v4/token";
	}

	public function baseUserResourceUrl()
	{
		return "https://www.googleapis.com/plus/v1/people/me?";
	}

	public function getUserInfo()
	{
		$response = $this->client->get($this->baseUserResourceUrl() . 
			'access_token=' . $this->getAccessToken() . 
			'&key=' . $this->client_secret 
		);

		return new \Oauth\User\GoogleUser(json_decode($response->getBody(),true));
	}
}