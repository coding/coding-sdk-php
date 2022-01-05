<?php

namespace Coding;

class Iteration extends Base
{
    public function create(array $data)
    {
        $this->validate($data, [
            'Name' => 'string|required',
            'Goal' => 'nullable|string',
            'Assignee' => 'nullable|integer',
            'StartAt' => 'nullable|date_format:Y-m-d',
            'EndAt' => 'nullable|date_format:Y-m-d|after:StartAt',
        ]);
        $response = $this->client->requestProjectApi('CreateIteration', $data);
        return $response['Iteration'];
    }

    public function get(array $data)
    {
        $this->validate($data, [
            'IterationCode' => 'integer|required',
        ]);
        $response = $this->client->requestProjectApi('DescribeIteration', $data);
        return $response['Iteration'];
    }

    public function update(array $data)
    {
        $this->validate($data, [
            'IterationCode' => 'integer|required',
            'Name' => 'nullable|string',
            'Goal' => 'nullable|string',
            'Assignee' => 'nullable|integer',
            'StartAt' => 'nullable|date_format:Y-m-d',
            'EndAt' => 'nullable|date_format:Y-m-d|after:StartAt',
        ]);
        $response = $this->client->requestProjectApi('ModifyIteration', $data);
        return $response['Iteration'];
    }

    public function delete(array $data)
    {
        $this->validate($data, [
            'IterationCode' => 'integer|required',
        ]);
        $this->client->requestProjectApi('DeleteIteration', $data);
        return true;
    }
}
