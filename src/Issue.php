<?php

namespace Coding;

use Illuminate\Validation\Rule;

class Issue extends Base
{
    public const TYPE = ['DEFECT', 'REQUIREMENT', 'MISSION', 'EPIC', 'SUB_TASK'];
    public const PRIORITY = [
        '低' => '0',
        '中' => '1',
        '高' => '2',
        '紧急' => '3',
    ];

    public function create(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'Name' => 'string|required',
            'Priority' => [
                'string',
                'required',
                Rule::in(array_values(self::PRIORITY)),
            ],
            'Type' => [
                'required',
                Rule::in(self::TYPE),
            ],
            // 事项类型 ID，比如「用户故事」属于「需求」，必须指定此 ID，而「缺陷」就一种，不需要
            'IssueTypeId' => 'nullable|integer',
            'ParentCode' => 'nullable|integer',
            'StatusId' => 'nullable|integer',
            'AssigneeId' => 'nullable|integer',
            'Description' => 'nullable|string',
            'StartDate' => 'nullable|date_format:Y-m-d',
            'DueDate' => 'nullable|date_format:Y-m-d|after:StartDate',
            'WorkingHours' => 'nullable|numeric',
            // 项目模块 ID
            'ProjectModuleId' => 'nullable|integer',
            // 事项关注人 ID 列表
            'WatcherIds' => 'nullable|array',
            'WatcherIds.*' => 'integer',
            // 项目缺陷类型 ID
            'DefectTypeId' => 'nullable|integer',
            // 项目需求类型 ID
            'RequirementTypeId' => 'nullable|integer',
            'IterationCode' => 'nullable|integer',
            'EpicCode' => 'nullable|integer',
            'StoryPoint' => 'nullable|string',
            'LabelIds' => 'nullable|array',
            'FileIds' => 'nullable|array',
            // 排序目标位置的事项 code
            'TargetSortCode' => 'nullable|integer',
            // 第三方链接列表 Array of CreateThirdLinkForm
            'ThirdLinks' => 'nullable|array',
            // 自定义属性值列表 Array of IssueCustomFieldForm
            'CustomFieldValues' => 'nullable|array',
        ]);
        $response = $this->core->request('CreateIssue', $data);
        return $response['Issue'];
    }
}
