<?php

declare(strict_types=1);

use Tester\Assert;
use Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/TestUtils.php';

Environment::setup();

function test(string $description, Closure $fn): void
{
    echo $description, "\n";
    $fn();
}

class JestExpect
{
    public function __construct(private $testResult)
    {
    }

    public function toBe($val)
    {
        Assert::same($this->testResult, $val);
    }

    public function toEqual($val)
    {
        Assert::equal($this->testResult, $val);
    }
}

function expect($result)
{
    return new JestExpect($result);
}
