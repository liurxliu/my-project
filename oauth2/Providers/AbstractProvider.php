<?php

namespace Oauth\Providers;

use GuzzleHttp\Client;

abstract class AbstractProvider
{
	protected $client;
	protected $scope = "email";
	protected $client_id;
	protected $client_secret;
	protected $redirect_uri;
	protected $access_token;
	protected $state;

	abstract public function BaseAuthUrl();
	abstract public function baseAccessTokenUrl();
	abstract public function baseUserResourceUrl();
	abstract public function getUserInfo();

	public function __construct(Client $client, array $clientInfo)
	{
		foreach($clientInfo as $property => $value) {
			$this->$property = $value;
		}

		$this->client = $client;
	}

	public function getAuthUrl()
	{
		$base = $this->BaseAuthUrl();
		$query = $this->authUrlQuery();
		return $base . $query;
	}

	public function redirect()
	{
		return redirect($this->getAuthUrl());
	}

	public function getAccessToken()
	{
		if (! $this->checkState()) {
        	throw new \Exception("State don't match.");
        }

		$response = $this->client->post($this->baseAccessTokenUrl(), [
			'headers' => [
				'Accept' => 'application/json'
			],
			'form_params' => $this->setFormData(request('code'))
		]);
		
		$this->access_token = json_decode($response->getBody(), true)['access_token'];
		return $this->access_token;
	}

	protected function authUrlQuery()
	{
		$queryInfo = $this->setQuery();
		$query = '';
		foreach ($queryInfo as $property => $value) {
			$query = $query . $property . '=' . $value . '&';
		}
		return trim($query, '&');
	}

	protected function getState()
	{
		$this->state = bin2hex(random_bytes(16));
		session(['state' => $this->state]);
		return $this->state;
	}


	public function checkState()
	{
		return request('state') === session('state');
	}

	protected function setFormData($code)
	{
		return [
			'code' => $code,
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri' => $this->redirect_uri,
			'grant_type' => 'authorization_code',
		];
	}

	protected function setQuery()
	{
		return [
			'response_type' => 'code',
			'access_type' => 'offline',
			'client_id' => $this->client_id,
			'redirect_uri' => $this->redirect_uri,
			'state' => $this->getState(),
			'scope' => $this->scope,
			'approval_prompt' => 'auto'
		];
	}
}