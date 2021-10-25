<?php

namespace Coding\Tests;

use Coding\Core;
use Faker\Factory;
use Faker\Generator;
use Mockery\Mock;
use PHPUnit\Framework\TestCase as PhpUnitTestBase;

class TestCase extends PhpunitTestBase
{
    protected Generator $faker;
    protected string $token;
    protected string $projectName;
    protected bool $needCoreMock = true;
    protected $coreMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->token = $this->faker->md5;
        $this->projectName = $this->faker->slug;
        if ($this->needCoreMock) {
            $this->coreMock = \Mockery::mock(Core::class, [])->makePartial();
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
