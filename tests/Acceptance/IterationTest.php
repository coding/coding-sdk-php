<?php

namespace Tests\Acceptance;

use Coding\Iteration;

class IterationTest extends TestCase
{
    public function testCrud()
    {
        $data = [
            'ProjectName' => $this->projectName,
            'Name' => $this->faker->sentence(2),
        ];

        $iteration = new Iteration($this->token);
        $createResult = $iteration->create($data);
        $this->assertTrue(is_numeric($createResult['Code']));

        $params = [
            'ProjectName' => $this->projectName,
            'IterationCode' => $createResult['Code'],
        ];
        $getResult = $iteration->get($params);
        $this->assertEquals($createResult['Name'], $getResult['Name']);

        $name = $this->faker->sentence(2);
        $updateResult = $iteration->update(array_merge($params, [
            'Name' => $name,
        ]));
        $this->assertEquals($name, $updateResult['Name']);

        $this->assertTrue($iteration->delete($params));
    }
}
