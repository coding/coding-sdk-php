<?php

namespace Tests\Unit;

use Coding\Core;
use Coding\Exceptions\ValidationException;
use Coding\Iteration;
use Tests\TestCase;

class IterationTest extends TestCase
{
    private Iteration $iteration;

    protected function setUp(): void
    {
        parent::setUp();
        $this->iteration = new Iteration($this->clientMock);
    }

    public function testCreateSuccessWithOnlyRequiredParams()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('CreateIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'Name' => $this->faker->title,
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'CreateIteration',
            $data
        ])->andReturn($response);

        $result = $this->iteration->create($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testCreateSuccessWithRequiredParamsAndNull()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('CreateIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'Name' => $this->faker->title,
            'Goal' => null,
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'CreateIteration',
            $data
        ])->andReturn($response);

        $result = $this->iteration->create($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testCreateSuccessWithAllParams()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('CreateIterationResponse.json')),
            true
        )['Response'];
        $startAt = $this->faker->date();
        $data = [
            'Name' => $this->faker->title,
            'Goal' => $this->faker->sentence,
            'Assignee' => $this->faker->randomNumber(),
            'StartAt' => $startAt,
            'EndAt' => date('Y-m-d', strtotime($startAt) + $this->faker->randomDigitNotZero() * 86400),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'CreateIteration',
            $data
        ])->andReturn($response);

        $result = $this->iteration->create($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testCreateFailedRequired()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field is required.');
        $this->iteration->create([]);
    }

    public function testCreateFailedBefore()
    {
        $data = [
            'Name' => $this->faker->title,
            'StartAt' => '2021-10-23',
            'EndAt' => '2021-10-22',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The end at must be a date after start at.');
        $this->iteration->create($data);
    }

    public function testGet()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'IterationCode' => $this->faker->randomNumber(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DescribeIteration',
            $data
        ])->andReturn($response);

        $result = $this->iteration->get($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testUpdate()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('ModifyIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'IterationCode' => $this->faker->randomNumber(),
            'Goal' => $this->faker->sentence,
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'ModifyIteration',
            $data
        ])->andReturn($response);

        $result = $this->iteration->update($data);
        $this->assertEquals($response['Iteration'], $result);
    }

    public function testDelete()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DeleteIterationResponse.json')),
            true
        )['Response'];
        $data = [
            'IterationCode' => $this->faker->randomNumber(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DeleteIteration',
            $data
        ])->andReturn($response);

        $this->assertTrue($this->iteration->delete($data));
    }
}
