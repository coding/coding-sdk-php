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

use Coding\Client;
use Coding\Iteration;

$client = new Client();
$projectName = 'project-foo';
$client->setProjectName($projectName);
$client->setProjectToken('c127894e5a851cef22dc317f882dfb9ca6054321');

$iteration = new Iteration($client);
$result = $iteration->create([
    'Name' => 'Sprint 1',
]);
$teamDomain = 'my-team';
echo "https://${teamDomain}.coding.net/p/{$projectName}/iterations/${result['Code']}/issues\n";
```

## Resources

- [CODING OPEN API](https://help.coding.net/openapi)
