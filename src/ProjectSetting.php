<?php

namespace Coding;

use Illuminate\Validation\Rule;

class ProjectSetting extends Base
{
    public function getIssueTypes(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
        ]);
        $response = $this->core->request('DescribeProjectIssueTypeList', $data);
        return $response['IssueTypes'];
    }

    public function getIssueStatuses(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'IssueType' => [
                'required_without:IssueTypeId',
                Rule::in(Issue::TYPE),
            ],
            'IssueTypeId' => 'nullable|integer',
        ]);
        $response = $this->core->request('DescribeProjectIssueStatusList', $data);
        return $response['ProjectIssueStatusList'];
    }
}
