<?php

declare(strict_types=1);

namespace Hopo\OpenApi;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;

class OpenApiNode implements ArrayAccess, Countable, Iterator
{
    /**
     * @var Array $resolved
     */
    private $resolved = [];
    private $resolvedDone = false;
    private $position;

    public function __construct(private array $root, private array $spec)
    {
        ///$this->resolved = $this;
        $this->position = key($this->root);
    }

    public function offsetSet($offset, $value): void
    {
        throw new OpenApiException('It is not allowd to change api specification.');
    }

    public function offsetExists($offset): bool
    {
        $this->resolveThis();
        return array_key_exists($offset, $this->resolved ?? []);
    }

    public function offsetUnset($offset): void
    {
        throw new OpenApiException('It is not allowd to change api specification.');
    }

    private function returnValue($value)
    {
        if (is_scalar($value)) {
            return $value;
        } elseif (is_array($value)) {
            $new = new self($this->root, (array) $value);
            return $new;
        } else {
            throw new NotImplementedException('Invalid type: ' . gettype($value));
        }
    }

    public function offsetGet($offset)
    {
        if (!$this->resolved) {
            $this->resolveThis();
        }
        $offsetParts = OpenApiUtils::withSelector($offset);
        $ret = $this->resolved;
        foreach ($offsetParts as $key) {
            $ret = $ret[$key];
        }
        return $this->returnValue($ret);
        //return array_key_exists($offset, $this->resolved ?? []) ? $this->returnValue($this->resolved[$offset]) : null;
    }

    public function toArray(): array
    {
        $this->resolveThis();
        return $this->resolved;
    }

    public function count(): int
    {
        $this->resolveThis();
        return count($this->resolved);
    }

    private function resolveThis(): void
    {
        if (!$this->resolvedDone) {
            $spec = OpenApiUtils::replaceReference($this->spec, $this->root, 1);
            $this->resolved = $spec;
            $this->resolvedDone = true;
        }
    }

    /******** Iterator ********* */

    public function current()
    {
        $this->resolveThis();
        return $this->returnValue(current($this->resolved));
    }

    public function key()
    {
        $this->resolveThis();
        return key($this->resolved);
    }

    public function next(): void
    {
        $this->resolveThis();
        next($this->resolved);
    }

    public function valid(): bool
    {
        $this->resolveThis();
        return key($this->resolved) !== null;
    }

    function rewind(): void
    {
        $this->resolveThis();
        reset($this->resolved);
    }
}
