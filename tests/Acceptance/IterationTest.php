<?php

namespace Tests\Acceptance;

use Coding\Iteration;

class IterationTest extends TestCase
{
    public function testCrud()
    {
        $params = [
            'Name' => $this->faker->sentence(2),
        ];

        $iteration = new Iteration($this->client);
        $createResult = $iteration->create($params);
        $this->assertTrue(is_numeric($createResult['Code']));

        $params = [
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
