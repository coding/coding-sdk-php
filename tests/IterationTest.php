<?php

namespace Coding\Tests;

use Coding\Core;
use Coding\Iteration;

class IterationTest extends TestCase
{
    public function testCreateSuccess()
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
}
