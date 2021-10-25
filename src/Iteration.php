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
}
