<?php

namespace Oauth\Providers;

use Oauth\Providers\AbstractProvider;

class FacebookProvider extends AbstractProvider
{
	public function BaseAuthUrl()
	{
		return "https://www.facebook.com/v3.0/dialog/oauth?";
	}

	public function baseAccessTokenUrl()
	{
		return "https://graph.facebook.com/v3.0/oauth/access_token";
	}

	public function baseUserResourceUrl()
	{
		return "https://graph.facebook.com/me";
	}

	public function getUserInfo()
	{
		$response = $this->client->get($this->baseUserResourceUrl(), [
			'query' => [
				'fields' => "id,name,email,picture.type(large)",
				'access_token' => $this->getAccessToken()
			]
		]);

		return new \Oauth\User\FacebookUser(json_decode($response->getBody(),true));
	}
}