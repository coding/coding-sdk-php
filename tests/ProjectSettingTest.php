<?php

namespace Coding\Tests;

use Coding\ProjectSetting;

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
}
