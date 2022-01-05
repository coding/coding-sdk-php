<?php

namespace Tests\Unit;

use Coding\Core;
use Coding\Issue;
use Tests\TestCase;

class IssueTest extends TestCase
{
    private Issue $issue;

    protected function setUp(): void
    {
        parent::setUp();
        $this->issue = new Issue($this->clientMock);
    }

    public function testCreateSuccessWithOnlyRequiredParams()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('CreateIssueResponse.json')),
            true
        )['Response'];
        $data = [
            'Name' => $this->faker->sentence,
            'Priority' => $this->faker->randomElement(Issue::PRIORITY),
            'Type' => $this->faker->randomElement(Issue::TYPE),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'CreateIssue',
            $data
        ])->andReturn($response);

        $result = $this->issue->create($data);
        $this->assertEquals($response['Issue'], $result);
    }

    public function testCreateSuccessWithAllParams()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('CreateIssueResponse.json')),
            true
        )['Response'];
        $startDate = $this->faker->date();
        $data = [
            'Name' => $this->faker->sentence,
            'Priority' => $this->faker->randomElement(Issue::PRIORITY),
            'Type' => $this->faker->randomElement(Issue::TYPE),
            'IssueTypeId' => $this->faker->randomNumber(),
            'ParentCode' => $this->faker->randomNumber(),
            'StatusId' => $this->faker->randomNumber(),
            'AssigneeId' => $this->faker->randomNumber(),
            'WatcherIds' => [$this->faker->randomNumber(), $this->faker->randomNumber()],
            'Description' => $this->faker->sentence(),
            'StartDate' => $startDate,
            'DueDate' => date('Y-m-d', strtotime($startDate) + $this->faker->randomDigitNotZero() * 86400),
            'WorkingHours' => $this->faker->randomDigitNotZero(),
            'ProjectModuleId' => $this->faker->randomNumber(),
            'DefectTypeId' => $this->faker->randomNumber(),
            'RequirementTypeId' => $this->faker->randomNumber(),
            'IterationCode' => $this->faker->randomNumber(),
            'EpicCode' => $this->faker->randomNumber(),
            'StoryPoint' => $this->faker->randomElement(['0.5', '1', '2', '3', '5', '8', '13', '20']),
            'LabelIds' => [$this->faker->randomNumber(), $this->faker->randomNumber()],
            'FileIds' => [$this->faker->randomNumber(), $this->faker->randomNumber()],
            'TargetSortCode' => $this->faker->randomDigitNotZero(),
            'ThirdLinks' => [
                [
                    'ThirdType' => 'MODAO',
                    'Link' => '<iframe src="https://modao.cc/app/7fb28d9af13827fd009f401579cbdc3cef2a456a/embed/v2" />',
                    'Title' => '墨刀原型',
                ],
                [
                    'ThirdType' => 'CODESIGN',
                    "Link" => 'https://codesign.qq.com/s/ALwE9VKWgl0X1Dp',
                    "Title" => 'CoDesign - 腾讯自研设计协作平台',
                ],
            ],
            'CustomFieldValues' => [
                [
                    // 用户单选
                    'Id' => $this->faker->randomNumber(),
                    'Content' => strval($this->faker->randomNumber()),
                ],
            ],
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'CreateIssue',
            $data
        ])->andReturn($response);

        $result = $this->issue->create($data);
        $this->assertEquals($response['Issue'], $result);
    }

    public function testDelete()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DeleteIssueResponse.json')),
            true
        )['Response'];
        $data = [
            'IssueCode' => $this->faker->randomNumber(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DeleteIssue',
            $data
        ])->andReturn($response);

        $this->assertTrue($this->issue->delete($data));
    }

    public function testGet()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('DescribeIssueResponse.json')),
            true
        )['Response'];
        $data = [
            'IssueCode' => $this->faker->randomNumber(),
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'DescribeIssue',
            $data
        ])->andReturn($response);

        $result = $this->issue->get($data);
        $this->assertEquals($response['Issue'], $result);
    }

    public function testUpdate()
    {
        $response = json_decode(
            file_get_contents($this->dataPath('ModifyIssueResponse.json')),
            true
        )['Response'];
        $data = [
            'IssueCode' => $this->faker->randomNumber(),
            'StoryPoint' => "1.0",
        ];
        $this->clientMock->shouldReceive('requestProjectApi')->times(1)->withArgs([
            'ModifyIssue',
            $data
        ])->andReturn($response);

        $result = $this->issue->update($data);
        $this->assertEquals($response['Issue'], $result);
    }
}
