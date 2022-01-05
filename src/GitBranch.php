<?php

declare(strict_types=1);

namespace Coding;

use Illuminate\Validation\Rule;

class GitBranch extends Base
{
    public function index(array $data): array
    {
        $this->validate($data, [
            'DepotId' => 'integer|required',
            'PageNumber' => 'integer',
            'PageSize' => 'integer',
            'KeyWord' => 'string', // 搜索关键字
        ]);
        $data['DepotId'] = intval($data['DepotId']);
        $response = $this->client->requestProjectApi('DescribeGitBranches', $data);
        return $response['Branches'];
    }
}
