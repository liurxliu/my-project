<?php

namespace Oauth\Providers;

use Oauth\Providers\AbstractProvider;

class GithubProvider extends AbstractProvider
{
	protected $scope = "user:email";
	public function BaseAuthUrl()
	{
		return "https://github.com/login/oauth/authorize?";
	}

	public function baseAccessTokenUrl()
	{
		return "https://github.com/login/oauth/access_token";
	}

	public function baseUserResourceUrl()
	{
		return "https://api.github.com/user";
	}

	public function getUserInfo()
	{
		$token = $this->getAccessToken();
		$header = array('Authorization' => "token {$token}");
		$userInfo = $this->client->get($this->baseUserResourceUrl(), [
			'headers' => $header
		]);

		$emailInfo = $this->client->get($this->baseUserResourceUrl() . '/emails', [
			'headers' => $header
		]);

		$user = json_decode($userInfo->getBody(),true);
		$email = json_decode($emailInfo->getBody(),true);
		return new \Oauth\User\GithubUser([
			'name' => $user['login'],
			'avatar_url' => $user['avatar_url'],
			'email' => $email[0]['email']
		]);
	}
}