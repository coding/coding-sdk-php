<?php

namespace Coding;

class Iteration
{
    private Core $core;

    public function __construct(string $token, Core $core = null)
    {
        $this->core = $core ?? new Core($token);
    }

    public function create(array $data)
    {
        $response = $this->core->request('CreateIteration', $data);
        return $response['Iteration'];
    }
}
