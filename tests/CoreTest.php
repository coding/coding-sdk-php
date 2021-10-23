<?php

namespace Coding\Tests;

use Coding\Exceptions\ApiError;
use Coding\Core;
use GuzzleHttp\Psr7\Response;

class CoreTest extends TestCase
{
    public function testRequestSuccess()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponse.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));

        $this->clientMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $this->token",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $core = new Core($this->token, $this->clientMock);
        $result = $core->request($action, $data);
        $this->assertEquals(json_decode($responseBody, true)['Response'], $result);
    }

    public function testRequestFailed()
    {
        $responseBody = file_get_contents($this->dataPath('CreateIterationResponseError.json'));
        $action = $this->faker->word;
        $number = ($this->faker->randomDigitNotZero());
        $data = array_combine($this->faker->words($number), $this->faker->words($number));

        $this->clientMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://e.coding.net/open-api',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "token $this->token",
                        'Content-Type' => 'application/json'
                    ],
                    'json' => array_merge([
                        'Action' => $action,
                    ], $data)
                ]
            )
            ->willReturn(new Response(200, [], $responseBody));
        $core = new Core($this->token, $this->clientMock);
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage(json_decode($responseBody, true)['Response']['Error']['Message']);
        $core->request($action, $data);
    }
}
