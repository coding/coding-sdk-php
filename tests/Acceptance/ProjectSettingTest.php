<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Coding\Core;
use Coding\ProjectSetting;

class ProjectSettingTest extends TestCase
{
    public function testGetIssueStatuses()
    {
        $projectSetting = new ProjectSetting($this->client);
        $result = $projectSetting->getIssueStatuses([
            'IssueType' => 'DEFECT',
        ]);
        $this->assertEquals('DEFECT', $result[0]['IssueType']);
    }
}
