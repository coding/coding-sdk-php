<?php

namespace Coding;

use Coding\Exceptions\ValidationException;
use Coding\Handlers\Validator;

abstract class Base
{
    protected Client $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    protected function validate(array $data, array $rules)
    {
        $validator = Validator::getInstance()->make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all()[0]);
        }
    }
}
