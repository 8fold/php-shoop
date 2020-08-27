<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FilterContracts\Shooped;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESString;

trait ArrayableImp
{
    private $temp;

    public function efToArray(): array
    {
        if (is_a($this, Foldable::class)) {
            return $this->asArray()->unfold();
        }
        return [];
    }

    public function offsetExists($offset): bool
    {
        if (is_a($this, Arrayable::class) and is_a($this, Foldable::class)) {
            return $this->hasAt($offset)->unfold();
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if (is_a($this, Arrayable::class) and is_a($this, Foldable::class)) {
            return $this->at($offset)->unfold();
        }
        return false;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_a($this, Arrayable::class) and is_a($this, Foldable::class)) {
            $this->main = $this->plusAt($value, $offset, true)->unfold();
        }
    }

    public function offsetUnset($offset): void
    {
        if (is_a($this, Arrayable::class) and is_a($this, Foldable::class)) {
            $this->minusAt($offset);

        } else {
            unset($this->main[$offset]);

        }
    }

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     */
    public function rewind(): void
    {
        if (is_a($this, Ordered::class) and is_a($this, Foldable::class)) {
            $this->temp = Apply::typeAsArray()->unfoldUsing($this->main);

        } else {
            $this->temp = Apply::typeAsDictionary()->unfoldUsing($this->main);

        }
    }

    // TODO: Should be able to make part of a generic implementation
    public function valid(): bool
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $member = key($this->temp);
        return isset($this->temp[$member]);
    }

    public function current()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $member = key($this->temp);
        return $this->temp[$member];
    }

    public function key()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        return key($this->temp);
    }

    public function next(): void
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }
}
