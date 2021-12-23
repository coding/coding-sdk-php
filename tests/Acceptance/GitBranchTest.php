<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\GitBranch;

class GitBranchTest extends TestCase
{
    public function testIndex()
    {
        $data = [
            'DepotId' => getenv('CODING_DEPOT_ID'),
        ];
        $branch = new GitBranch($this->token);
        $result = $branch->index($data);
        $names = [];
        foreach ($result as $branch) {
            $names[] = $branch['BranchName'];
            sort($names);
        }
        $this->assertEquals(['develop', 'main'], $names);
    }
}
