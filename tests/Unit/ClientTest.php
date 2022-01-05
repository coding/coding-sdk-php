<?php

declare(strict_types=1);

namespace Tests\Unit;

use Coding\Exceptions\ApiError;
use Coding\Client;
use Coding\Exceptions\ValidationException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private ClientInterface $httpMock;
    protected bool $needClientMock = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpMock = $this->getMockBuilder(GuzzleClient::class)->getMock();
    }

    public function testRequestSuccess()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponse.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));

        $this->httpMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $this->personalToken",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                        'ProjectName' => $this->projectName,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $client = new Client();
        $client->setHttpClient($this->httpMock);
        $client->setProjectName($this->projectName);
        $client->setPersonalToken($this->personalToken);
        $result = $client->requestProjectApi($action, $data);
        $this->assertEquals(json_decode($responseBody, true)['Response'], $result);
    }

    public function testRequestFailed()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponseError.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));

        $this->httpMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $this->personalToken",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $client = new Client();
        $client->setHttpClient($this->httpMock);
        $client->setPersonalToken($this->personalToken);
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage(json_decode($responseBody, true)['Response']['Error']['Message']);
        $client->request($action, $data, false);
    }

    public function testValidateProjectNameFailed()
    {
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));

        $this->httpMock->expects($this->never())->method('request');
        $client = new Client();
        $client->setHttpClient($this->httpMock);
        $client->setPersonalToken($this->personalToken);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Need set project name first.');
        $client->requestProjectApi($action, $data);
    }

    public function testUseProjectToken()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponse.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));
        $projectToken = $this->faker->md5;

        $this->httpMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $projectToken",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                        'ProjectName' => $this->projectName,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $client = new Client();
        $client->setHttpClient($this->httpMock);
        $client->setPersonalToken($this->personalToken);
        $client->setProjectName($this->projectName);
        $client->setProjectToken($projectToken);
        $result = $client->requestProjectApi($action, $data);
        $this->assertEquals(json_decode($responseBody, true)['Response'], $result);
    }


    public function testUsePersonalToken()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponse.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));
        $projectToken = $this->faker->md5;

        $this->httpMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $this->personalToken",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                        'ProjectName' => $this->projectName,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $client = new Client();
        $client->setHttpClient($this->httpMock);
        $client->setPersonalToken($this->personalToken);
        $client->setProjectName($this->projectName);
        $client->setProjectToken($projectToken);
        $client->usePersonalToken = true;
        $result = $client->requestProjectApi($action, $data);
        $this->assertEquals(json_decode($responseBody, true)['Response'], $result);
    }
}
