<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\Issue;
use Coding\ProjectSetting;

class IssueTest extends TestCase
{
    public function testCrud()
    {
        $data = [
            'Name' => $this->faker->sentence,
            'Priority' => $this->faker->randomElement(Issue::PRIORITY),
            'Type' => 'DEFECT',
        ];

        $issue = new Issue($this->client);
        $projectSetting = new ProjectSetting($this->client);
        $result = $issue->create($data);
        $this->assertTrue(is_numeric($result['Code']));

        $params = [
            'IssueCode' => $result['Code'],
        ];
        $result = $issue->get($params);
        $this->assertEquals($data['Name'], $result['Name']);
        $this->assertEmpty($result['StoryPoint']);

        $statuses = $projectSetting->getIssueStatuses([
            'IssueTypeId' => $result['IssueTypeId'],
        ]);

        $storyPoint = '1.0';
        $statusId = end($statuses)['IssueStatusId'];
        $result = $issue->update(array_merge($params, [
            'StoryPoint' => $storyPoint,
            'StatusId' => $statusId,
        ]));
        $this->assertEquals($storyPoint, $result['StoryPoint']);
        $this->assertEquals($statusId, $result['IssueStatusId']);

        $this->assertTrue($issue->delete($params));
    }
}
