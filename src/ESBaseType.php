<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Shoop;

/**
 * Attention maintainers: Do not use Shoop classess and methods
 * within this class as it can cause memory overflow exceptions.
 */
class ESBaseType implements \Countable
{
//-> Comparison safer to use Shoop
    static public function isShoop($potential): bool
    {
        return is_subclass_of($potential, ESBaseType::class);
    }

    static protected function isAssociativeArray($value): bool
    {
        if (is_array($value)) {
            return array_keys($value) !== range(0, count($value) - 1);
        }
        return false;
    }

    public function isEmpty(): ESBool
    {
        $result = empty($this->unfold());
        return Shoop::bool($result);
    }

    public function isSame($compare): ESBool
    {
        $isSub = is_subclass_of($compare, ESBaseType::class);
        $isNotSub = Shoop::bool($isSub)->toggle()->unfold();
        if ($isNotSub) {
            $compare = $this->instanceFromValue($compare);
        }
        return Shoop::bool($this->unfold() === $compare->unfold());
    }

    static public function valueisSubclass($value, string $className)
    {
        # code...
    }

    static public function valueisNotSubclass($value, string $className)
    {
        # code...
    }

    static public function valueIsClass($value, string $className)
    {
        # code...
    }

    static public function valueIsNotClass($value, string $className)
    {
        # code...
    }

    static public function valueIsArray($value)
    {
        return is_array($value) || (self::isShoop($value) && is_a($value, ESArray::class));
    }

    static public function valueIsNotArray($value)
    {
        return ! self::valueIsArray($value);
    }

    public function isArray()
    {
        return is_array($this->unfold());
    }

    public function isNotArray()
    {
        return ! $this->isArray();
    }

    final public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }

//-> Enumerable
    public function count()
    {
        return Shoop::int(count($this->enumerated()->unfold()));
    }

    public function countIsGreaterThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class)
            ->unfold();
        return $this->count()->isGreaterthan($value);
    }

    public function countIsNotGreaterThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isNotGreaterThan($value);
    }

    public function countIsLessThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isLessThan($value);
    }

    public function countIsNotLessThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isNotLessThan($value);
    }
}
