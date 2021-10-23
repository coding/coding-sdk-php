<?php

namespace Coding;

use Coding\Exceptions\ApiError;
use GuzzleHttp\Client;

class Core
{
    protected string $token;
    protected Client $client;

    public function __construct(string $token = '', Client $client = null)
    {
        $this->token = $token;
        $this->client = $client ?? new Client();
    }

    public function request(string $action, $data)
    {
        $response = $this->client->request('POST', 'https://e.coding.net/open-api', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "token $this->token",
                'Content-Type' => 'application/json'
            ],
            'json' => array_merge([
                'Action' => $action,
            ], $data),
        ]);
        $result = json_decode($response->getBody(), true);
        if (isset($result['Response']['Error']['Message'])) {
            throw new ApiError($result['Response']['Error']['Message']);
        }
        return $result['Response'];
    }
}
