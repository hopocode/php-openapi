<?php

declare(strict_types=1);

namespace PhpJest;

use Nette\SmartObject;
use Tester\Assert;

class JestExpect
{
    use SmartObject;

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

    public function toBeInstanceOf(string $type)
    {
        Assert::true($this->testResult instanceof $type);
    }
}
