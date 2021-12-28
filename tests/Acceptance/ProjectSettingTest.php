<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\ProjectSetting;

class ProjectSettingTest extends TestCase
{
    public function testGetIssueStatuses()
    {
        $projectSetting = new ProjectSetting($this->token);
        $result = $projectSetting->getIssueStatuses([
            'ProjectName' => $this->projectName,
            'IssueType' => 'DEFECT',
        ]);
        $this->assertEquals('DEFECT', $result[0]['IssueType']);
    }
}
