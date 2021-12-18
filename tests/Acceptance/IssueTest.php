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

        // delete
        $data = [
            'ProjectName' => $this->projectName,
            'IssueCode' => $result['Code'],
        ];
        $this->assertTrue($issue->delete($data));
    }
}
