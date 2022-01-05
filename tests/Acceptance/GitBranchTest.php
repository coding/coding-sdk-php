<?php

declare(strict_types=1);

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
        $branch = new GitBranch($this->client);
        $result = $branch->index($data);
        $names = [];
        foreach ($result as $branch) {
            $names[] = $branch['BranchName'];
            sort($names);
        }
        $this->assertEquals(['develop', 'main'], $names);
    }
}
