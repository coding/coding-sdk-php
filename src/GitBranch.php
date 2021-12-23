<?php

namespace Coding;

use Illuminate\Validation\Rule;

class GitBranch extends Base
{
    public function index(array $data)
    {
        $this->validate($data, [
            'DepotId' => 'integer|required',
            'PageNumber' => 'integer',
            'PageSize' => 'integer',
            'KeyWord' => 'string', // 搜索关键字
        ]);
        $data['DepotId'] = intval($data['DepotId']);
        $response = $this->core->request('DescribeGitBranches', $data);
        return $response['Branches'];
    }
}
