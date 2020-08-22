<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Shoop\PipeFilters;

use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;

trait ArrayableImp
{
    private $temp;

    //TODO: PHP 8.0 - int|string|ESInteger|ESString
    public function hasMember($member)
    {
        return Shoop::this(
            $this->offsetExists($member)
        );
    }

    public function offsetExists($offset): bool
    {
        return Apply::hasMember($offset)->unfoldUsing($this->main);
    }

    public function at($member)
    {
        return Shoop::this(
            $this->offsetGet($member)
        );
    }

    public function offsetGet($offset)
    {
        return Apply::at($offset)->unfoldUsing($this->main);
    }

    public function plusMember($value, $member)
    {
        $this->offsetSet($member, $value);
        return static::fold($this->main);
    }

    public function offsetSet($offset, $value): void
    {
        $this->main = Apply::plusMember($value, $offset)
            ->unfoldUsing($this->main);
    }

    public function minusMember($member)
    {
        $this->offsetUnset($member);
        return static::fold($this->main);
    }

    public function offsetUnset($offset): void
    {
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
        return Apply::hasMember($member)->unfoldUsing($this->temp);
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
