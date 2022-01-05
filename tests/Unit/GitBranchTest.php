<?php

namespace Tests\Unit;

use Coding\Core;
use Coding\GitBranch;
use Tests\TestCase;

class GitBranchTest extends TestCase
{
    public function testIndex()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeGitBranchesResponse.json')),
            true
        )['Response'];
        $data = [
            'DepotId' => $this->faker->randomNumber(),
            'PageNumber' => $this->faker->randomNumber(),
            'PageSize' => $this->faker->randomNumber(),
            'KeyWord' => $this->faker->word(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DescribeGitBranches',
            $data
        ])->andReturn($response);

        $branch = new GitBranch($this->clientMock);
        $result = $branch->index($data);
        $this->assertEquals($response['Branches'], $result);
    }
}
