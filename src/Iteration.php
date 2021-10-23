<?php

namespace Coding;

use Coding\Exceptions\ValidationException;
use Coding\Handlers\Validator;

class Iteration
{
    private Core $core;

    public function __construct(string $token, Core $core = null)
    {
        $this->core = $core ?? new Core($token);
    }

    public function create(array $data)
    {
        $validator = Validator::getInstance()->make($data, [
            'ProjectName' => 'string|required',
            'Name' => 'string|required',
            'Goal' => 'string',
            'Assignee' => 'integer',
            'StartAt' => 'date_format:Y-m-d',
            'EndAt' => 'date_format:Y-m-d|after:StartAt',
        ]);
        if ($validator->fails()) {
            // TODO Laravel ValidationException no message
            throw new ValidationException($validator->errors()->all()[0]);
        }
        $response = $this->core->request('CreateIteration', $data);
        return $response['Iteration'];
    }
}
