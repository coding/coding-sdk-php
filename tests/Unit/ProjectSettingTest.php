<?php

namespace Tests\Unit;

use Coding\Issue;
use Coding\ProjectSetting;
use Tests\TestCase;

class ProjectSettingTest extends TestCase
{
    public function testGetIssueTypes()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeProjectIssueTypeListResponse.json')),
            true
        )['Response'];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DescribeProjectIssueTypeList'
        ])->andReturn($response);

        $projectSetting = new ProjectSetting($this->clientMock);
        $result = $projectSetting->getIssueTypes();
        $this->assertEquals($response['IssueTypes'], $result);
    }

    public function testGetIssueStatuses()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeProjectIssueStatusListResponse.json')),
            true
        )['Response'];
        $data = [
            'IssueType' => $this->faker->randomElement(Issue::TYPE),
            'IssueTypeId' => $this->faker->randomNumber(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DescribeProjectIssueStatusList',
            $data
        ])->andReturn($response);

        $projectSetting = new ProjectSetting($this->clientMock);
        $result = $projectSetting->getIssueStatuses($data);
        $this->assertEquals($response['ProjectIssueStatusList'], $result);
    }
}
