<?php

namespace Coding;

use Coding\Exceptions\ValidationException;
use Coding\Handlers\Validator;

abstract class Base
{
    protected Core $core;

    public function __construct(string $token = '', Core $core = null)
    {
        $this->core = $core ?? new Core($token);
    }

    public function setToken(string $token)
    {
        $this->core->setToken($token);
    }

    protected function validate(array $data, array $rules)
    {
        $validator = Validator::getInstance()->make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all()[0]);
        }
    }
}
