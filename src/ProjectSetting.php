<?php

namespace Coding;

use Illuminate\Validation\Rule;

class ProjectSetting extends Base
{
    public function getIssueTypes()
    {
        $response = $this->client->requestProjectApi('DescribeProjectIssueTypeList');
        return $response['IssueTypes'];
    }

    public function getIssueStatuses(array $data)
    {
        $this->validate($data, [
            'IssueType' => [
                'required_without:IssueTypeId',
                Rule::in(Issue::TYPE),
            ],
            'IssueTypeId' => 'nullable|integer',
        ]);
        $response = $this->client->requestProjectApi('DescribeProjectIssueStatusList', $data);
        return $response['ProjectIssueStatusList'];
    }
}
