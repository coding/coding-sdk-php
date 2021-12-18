<?php

namespace Tests\Acceptance;

use Coding\Core;
use InvalidArgumentException;
use Faker\Factory;
use Faker\Generator;
use Mockery\Mock;
use PHPUnit\Framework\TestCase as PhpUnitTestBase;

class TestCase extends PhpUnitTestBase
{
    protected Generator $faker;
    protected string $token;
    protected string $projectName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->token = getenv('CODING_TOKEN');
        $this->projectName = getenv('CODING_PROJECT_NAME');
        if (empty($this->token) || empty($this->projectName)) {
            throw new InvalidArgumentException('Please set CODING_TOKEN and CODING_PROJECT_NAME environment variables');
        }
    }
}
