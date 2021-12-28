<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\Issue;

class IssueTest extends TestCase
{
    public function testCrud()
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
        $this->assertEmpty($result['StoryPoint']);

        $params['StoryPoint'] = '1.0';
        $result = $issue->update($params);
        $this->assertEquals('1.0', $result['StoryPoint']);

        $this->assertTrue($issue->delete($params));
    }
}
