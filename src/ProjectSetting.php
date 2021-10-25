<?php

namespace Coding;

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
}
