<?php

namespace Coding\Tests;

use Coding\Core;
use Coding\Exceptions\ValidationException;
use Coding\Iteration;

class IterationTest extends TestCase
{
    public function testCreateSuccessWithOnlyRequiredParams()
    {
        $coreMock = \Mockery::mock(Core::class, [])->makePartial();

        $response = json_decode(
            file_get_contents($this->dataPath('CreateIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'ProjectName' => $this->projectName,
            'Name' => $this->faker->title,
        ];
        $coreMock->shouldReceive('request')->times(1)->withArgs([
            'CreateIteration',
            $data
        ])->andReturn($response);

        $iteration = new Iteration($this->token, $coreMock);
        $result = $iteration->create($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testCreateSuccessWithAllParams()
    {
        $coreMock = \Mockery::mock(Core::class, [])->makePartial();

        $response = json_decode(
            file_get_contents($this->dataPath('CreateIterationResponse.json')),
            true
        )['Response'];
        $startAt = $this->faker->date();
        $data = [
            'ProjectName' => $this->projectName,
            'Name' => $this->faker->title,
            'Goal' => $this->faker->sentence,
            'Assignee' => $this->faker->randomNumber(),
            'StartAt' => $startAt,
            'EndAt' => date('Y-m-d', strtotime($startAt) + $this->faker->randomDigitNotZero() * 86400),
        ];
        $coreMock->shouldReceive('request')->times(1)->withArgs([
            'CreateIteration',
            $data
        ])->andReturn($response);

        $iteration = new Iteration('', $coreMock);
        $iteration->setToken($this->token);
        $result = $iteration->create($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testCreateFailedRequired()
    {
        $data = [
            'ProjectName' => $this->projectName,
        ];

        $iteration = new Iteration($this->token);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field is required.');
        $iteration->create($data);
    }

    public function testCreateFailedBefore()
    {
        $data = [
            'ProjectName' => $this->projectName,
            'Name' => $this->faker->title,
            'StartAt' => '2021-10-23',
            'EndAt' => '2021-10-22',
        ];

        $iteration = new Iteration($this->token);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The end at must be a date after start at.');
        $iteration->create($data);
    }
}
