<?php

namespace Coding\Tests;

use Faker\Factory;
use Faker\Generator;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase as BaseTestBase;

class TestCase extends BaseTestBase
{
    protected Generator $faker;
    protected Client $clientMock;
    protected string $token;
    protected string $projectName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->clientMock = $this->getMockBuilder(Client::class)->getMock();
        $this->token = $this->faker->md5;
        $this->projectName = $this->faker->slug;
    }

    protected function dataPath($fileName): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            'data',
            $fileName
        ]);
    }
}
