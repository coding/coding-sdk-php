<?php

declare(strict_types=1);

namespace Coding\Handlers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class Validator extends Factory
{
    public static function getInstance(): Factory
    {
        static $validator = null;
        if ($validator === null) {
            $fileLoader = new FileLoader(new Filesystem(), __DIR__ . '/../../lang');
            $translator = new Translator($fileLoader, 'en');
            $validator = new Factory($translator);
        }
        return $validator;
    }
}
