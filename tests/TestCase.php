<?php

namespace Tests;

use Coding\Client;
use Faker\Factory;
use Faker\Generator;
use Mockery\Mock;
use PHPUnit\Framework\TestCase as PhpUnitTestBase;

class TestCase extends PhpUnitTestBase
{
    protected Generator $faker;
    protected string $personalToken;
    protected string $projectName;
    protected bool $needClientMock = true;
    protected $clientMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->personalToken = $this->faker->md5;
        $this->projectName = $this->faker->slug;
        if ($this->needClientMock) {
            $this->clientMock = \Mockery::mock(Client::class, [])->makePartial();
            $this->clientMock->setPersonalToken($this->personalToken);
            $this->clientMock->setProjectName($this->projectName);
        }
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
