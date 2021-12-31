<?php

namespace Coding;

class Iteration extends Base
{
    public function create(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'Name' => 'string|required',
            'Goal' => 'nullable|string',
            'Assignee' => 'nullable|integer',
            'StartAt' => 'nullable|date_format:Y-m-d',
            'EndAt' => 'nullable|date_format:Y-m-d|after:StartAt',
        ]);
        $response = $this->core->request('CreateIteration', $data);
        return $response['Iteration'];
    }

    public function get(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'IterationCode' => 'integer|required',
        ]);
        $response = $this->core->request('DescribeIteration', $data);
        return $response['Iteration'];
    }

    public function update(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'IterationCode' => 'integer|required',
            'Name' => 'nullable|string',
            'Goal' => 'nullable|string',
            'Assignee' => 'nullable|integer',
            'StartAt' => 'nullable|date_format:Y-m-d',
            'EndAt' => 'nullable|date_format:Y-m-d|after:StartAt',
        ]);
        $response = $this->core->request('ModifyIteration', $data);
        return $response['Iteration'];
    }

    public function delete(array $data)
    {
        $this->validate($data, [
            'ProjectName' => 'string|required',
            'IterationCode' => 'integer|required',
        ]);
        $this->core->request('DeleteIteration', $data);
        return true;
    }
}
