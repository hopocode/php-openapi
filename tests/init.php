<?php

declare(strict_types=1);

use PhpJest\JestExpect;
use Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/JestExpect.php';
require __DIR__ . '/TestUtils.php';

Environment::setup();

function test(string $description, Closure $fn): void
{
    echo $description, "\n";
    $fn();
}

function expect($result)
{
    return new JestExpect($result);
}
