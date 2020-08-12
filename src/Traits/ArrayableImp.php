<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESBool;

// use Eightfold\Shoop\Helpers\{
//     Type,
//     PhpIndexedArray,
//     PhpAssociativeArray
// };

// use Eightfold\Shoop\{
//     Interfaces\Shooped,
//     Shoop,
//     ESArray,
//     ESBool,
//     ESInt,
//     ESString,
//     ESObject,
//     ESJson,
//     ESDictionary
// };

trait ArrayableImp
{
    private $temp;

// -> Arrayable
    public function array(): ESArray
    {
        $type = gettype($this->main);
        $method = "{$type}ToArray";
        $array = Php::{$method}($this->main);
        return ESArray::fold($array);
    }

    // TODO: PHP 8.0 - int|ESInt -> any|ESBool
    // TODO: Test callable
    public function hasMember($member, callable $closure = null)
    {
        $bool   =  $this->offsetExists($member);
        $bool   = ESBool::fold($bool);
        $string = static::fold($this->main);
        return ($closure === null) ? $bool : $closure($bool, $string);
    }

    public function offsetExists($offset): bool
    {
        $type = gettype($this->main);
        $method = "{$type}HasOffset";
        return Php::{$method}($this->main, $offset);
    }

    public function getMember($member, callable $callable = null)
    {
        $character = $this->offsetGet($member);
        return ($callable === null)
            ? $character
            : $callable($character);
    }

    public function offsetGet($offset)
    {
        $type = gettype($this->main);
        $method = "{$type}GetOffset";
        return Php::{$method}($this->main, $offset);
    }

    public function setMember($member, $value)
    {
        $this->offsetSet($member, $value);
        return ESString::fold($this->main);
    }

    public function offsetSet($offset, $value): void
    {
        $type = gettype($this->main);
        $method = "{$type}SetOffset";
        $this->main = Php::{$method}($this->main, $offset, $value);
    }

    public function stripMember($member)
    {
        $this->offsetUnset($member);
        return ESString::fold($this->main);
    }

    public function offsetUnset($offset): void
    {
        $type = gettype($this->main);
        $method = "{$type}StripOffset";
        $this->main = Php::{$method}($offset);
    }

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     */
    public function rewind(): void
    {
        $type = gettype($this->main);
        $method = $type ."ToArray";
        $this->temp = Php::{$method}($this->main);
    }

    // TODO: Should be able to make part of a generic implementation
    public function valid(): bool
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        return array_key_exists(key($this->temp), $this->temp);
    }

    public function current()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $member = key($temp);
        return $temp[$member];
    }

    public function key()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $member = key($temp);
        if (is_int($member)) {
            return Type::sanitizeType($member, ESInt::class, "int")->unfold();
        }
        return Type::sanitizeType($member, ESString::class, "string")->unfold();
    }

    public function next(): void
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }
}
