<?php

declare(strict_types=1);

namespace Coding;

use Coding\Exceptions\ApiError;
use Coding\Exceptions\ValidationException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;

class Client
{
    private const API_URL = 'https://e.coding.net/open-api';

    protected array $config;
    protected string $token;
    public bool $usePersonalToken = false;
    protected ?ClientInterface $http = null;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'api_url' => self::API_URL,
            'personal_token' => '',
            'project_name' => '',
            'project_token' => '',
        ], $config);
    }

    public function setHttpClient(ClientInterface $http): void
    {
        $this->http = $http;
    }

    public function getHttpClient(): ClientInterface
    {
        if (is_null($this->http)) {
            $this->http = new GuzzleClient();
        }

        return $this->http;
    }

    public function request(string $action, array $data): array
    {
        $params = ['Action' => $action];
        $response = $this->getHttpClient()->request('POST', $this->config['api_url'], [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'token ' . $this->getToken(),
                'Content-Type' => 'application/json'
            ],
            'json' => array_merge($params, $data),
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        if (isset($result['Response']['Error']['Message'])) {
            throw new ApiError($result['Response']['Error']['Message']);
        }
        return $result['Response'];
    }

    public function requestProjectApi(string $action, array $data = []): array
    {
        if (empty($this->config['project_name'])) {
            throw new ValidationException('Need set project name first.');
        }
        $data['ProjectName'] = $this->config['project_name'];
        return $this->request($action, $data);
    }

    public function setPersonalToken(string $token): void
    {
        $this->config['personal_token'] = $token;
    }

    public function setProjectName(string $projectName): void
    {
        $this->config['project_name'] = $projectName;
    }

    public function setProjectToken(string $token): void
    {
        $this->config['project_token'] = $token;
    }

    private function getToken(): string
    {
        if ($this->usePersonalToken) {
            if (empty($this->config['personal_token'])) {
                throw new InvalidArgumentException('Need set project token first.');
            }
            return $this->config['personal_token'];
        }
        return !empty($this->config['project_token']) ?
            $this->config['project_token'] : $this->config['personal_token'];
    }
}
