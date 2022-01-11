<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Coding\Client;
use InvalidArgumentException;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase as PhpUnitTestBase;

class TestCase extends PhpUnitTestBase
{
    protected Generator $faker;
    protected Client $client;
    protected string $projectName;

    protected function setUp(): void
    {
        parent::setUp();
        $personalToken = getenv('CODING_PERSONAL_TOKEN') ?: '';
        $projectName = getenv('CODING_PROJECT_NAME');
        $projectToken = getenv('CODING_PROJECT_TOKEN') ?: '';
        if (empty($personalToken) && empty($projectToken)) {
            throw new InvalidArgumentException('Please set CODING_PERSONAL_TOKEN or CODING_PROJECT_TOKEN'
             . ' environment variables');
        }
        if (empty($projectName)) {
            throw new InvalidArgumentException('Please set CODING_PROJECT_NAME environment variable');
        }

        $this->faker = Factory::create();
        $this->client = new Client();
        $this->client->setPersonalToken($personalToken);
        $this->client->setProjectName($projectName);
        $this->client->setProjectToken($projectToken);
        $this->projectName = $projectName;
    }
}
