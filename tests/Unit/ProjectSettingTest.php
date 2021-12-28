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
        $data = [
            'ProjectName' => $this->projectName,
        ];
        $this->coreMock->shouldReceive('request')->times(1)->withArgs([
            'DescribeProjectIssueTypeList',
            $data
        ])->andReturn($response);

        $projectSetting = new ProjectSetting($this->token, $this->coreMock);
        $result = $projectSetting->getIssueTypes($data);
        $this->assertEquals($response['IssueTypes'], $result);
    }

    public function testGetIssueStatuses()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeProjectIssueStatusListResponse.json')),
            true
        )['Response'];
        $data = [
            'ProjectName' => $this->projectName,
            'IssueType' => $this->faker->randomElement(Issue::TYPE),
            'IssueTypeId' => $this->faker->randomNumber(),
        ];
        $this->coreMock->shouldReceive('request')->times(1)->withArgs([
            'DescribeProjectIssueStatusList',
            $data
        ])->andReturn($response);

        $projectSetting = new ProjectSetting($this->token, $this->coreMock);
        $result = $projectSetting->getIssueStatuses($data);
        $this->assertEquals($response['ProjectIssueStatusList'], $result);
    }
}
