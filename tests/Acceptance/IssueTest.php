<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\Issue;

class IssueTest extends TestCase
{
    public function testCreateAndDelete()
    {
        $data = [
            'ProjectName' => $this->projectName,
            'Name' => $this->faker->sentence,
            'Priority' => $this->faker->randomElement(Issue::PRIORITY),
            'Type' => 'DEFECT',
        ];

        $issue = new Issue($this->token);
        $result = $issue->create($data);
        $this->assertTrue(is_numeric($result['Code']));

        $params = [
            'ProjectName' => $this->projectName,
            'IssueCode' => $result['Code'],
        ];
        $result = $issue->get($params);
        $this->assertEquals($data['Name'], $result['Name']);
        $this->assertTrue($issue->delete($params));
    }
}
