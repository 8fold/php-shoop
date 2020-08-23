<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Arrayable;

use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESString;

trait ArrayableImp
{
    private $temp;

    public function efToArray(): array
    {
        if (is_a($this, Arrayable::class)) {
            return $this->asArray()->unfold();
        }
        return [];
    }

    public function offsetExists($offset): bool
    {
        die("offsetExists");
        return Apply::hasMember($offset)->unfoldUsing($this->main);
    }

    public function offsetGet($offset)
    {
        // die("offsetGet");
        return Apply::at($offset)->unfoldUsing($this->main);
    }

    public function offsetSet($offset, $value): void
    {
        die("offsetSet");
        $this->main = Apply::plusMember($value, $offset)
            ->unfoldUsing($this->main);
    }

    public function offsetUnset($offset): void
    {
        die("offsetUnset");
        $this->main = Apply::minusMember($offset)->unfoldUsing($this->main);
    }

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     */
    public function rewind(): void
    {
        if (is_a($this, ESString::class) or
            is_a($this, ESInteger::class) or
            is_a($this, ESArray::class)
        ) {
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
        return Apply::hasMembers($member)->unfoldUsing($this->temp);
    }

    public function current()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $member = key($this->temp);
        return Apply::at($member)->unfoldUsing($this->temp);
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

    /**
     * @deprecated
     */
    public function stripMember($member)
    {
        return $this->minusMember($member);
    }

    /**
     * @deprecated
     */
    public function setMember($member, $value)
    {
        $this->plusMember();
    }

    /**
     * @deprecated
     */
    public function getMember($member, callable $callable = null)
    {
        return $this->at($member);
    }
}
