# CODING SDK for PHP

[![codecov](https://codecov.io/gh/Coding/coding-sdk-php/branch/main/graph/badge.svg?token=aaJqvjWodd)](https://codecov.io/gh/Coding/coding-sdk-php)
[![CI](https://github.com/Coding/coding-sdk-php/actions/workflows/ci.yml/badge.svg)](https://github.com/Coding/coding-sdk-php/actions/workflows/ci.yml)
[![Total Downloads](http://poser.pugx.org/coding/sdk/downloads)](https://packagist.org/packages/coding/sdk)
[![PHP Version Require](http://poser.pugx.org/coding/sdk/require/php)](https://www.php.net/supported-versions.php)

## Install

```shell
composer require coding/sdk
```

## Examples

### Create Iteration

```php
<?php

require 'vendor/autoload.php';

use Coding\Iteration;

$iteration = new Iteration('c127894e5a851cef22dc317f882dfb9ca6054321');
$projectName = 'project-foo';
$result = $iteration->create([
    'ProjectName' => $projectName,
    'Name' => 'Sprint 1',
]);
echo "https://my-team.coding.net/p/{$projectName}/iterations/${result['Code']}/issues\n";
```

## Resources

- [CODING OPEN API](https://help.coding.net/openapi)
