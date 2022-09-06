<?php

declare(strict_types=1);

function describe(string $description, Closure $fn): void
{
    echo $description, "\n";
    $fn();
}

function test(string $description, Closure $fn): void
{
    echo '   ' . $description, "\n";
    $fn();
}

function expect($result)
{
    return new \PhpJest\JestExpect($result);
}
